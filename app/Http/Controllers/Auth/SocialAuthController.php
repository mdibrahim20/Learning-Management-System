<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    private const PROVIDERS = ['google'];

    public function redirect(string $provider): RedirectResponse
    {
        if (!in_array($provider, self::PROVIDERS, true)) {
            abort(404);
        }

        if (!$this->providerIsConfigured($provider)) {
            return redirect()->route('login')->with([
                'message' => ucfirst($provider) . ' login is not configured yet.',
                'alert-type' => 'error',
            ]);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        if (!in_array($provider, self::PROVIDERS, true)) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable $exception) {
            return redirect()->route('login')->with([
                'message' => ucfirst($provider) . ' login failed. Please try again.',
                'alert-type' => 'error',
            ]);
        }

        $providerId = (string) $socialUser->getId();
        $email = $socialUser->getEmail() ?: $this->fallbackEmail($provider, $providerId);

        $user = User::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if (!$user) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $user->update([
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: $user->name,
                'provider' => $provider,
                'provider_id' => $providerId,
                'email_verified_at' => $user->email_verified_at ?: Carbon::now(),
                'photo' => $socialUser->getAvatar() ?: $user->photo,
            ]);
        } else {
            $user = User::create([
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: ucfirst($provider) . ' User',
                'email' => $email,
                'password' => Hash::make(Str::random(40)),
                'provider' => $provider,
                'provider_id' => $providerId,
                'email_verified_at' => Carbon::now(),
                'photo' => $socialUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        $url = '/dashboard';
        if ($user->role === 'admin') {
            $url = '/admin/dashboard';
        } elseif ($user->role === 'instructor') {
            $url = '/instructor/dashboard';
        }

        return redirect()->intended($url)->with([
            'message' => 'Login Successfully',
            'alert-type' => 'success',
        ]);
    }

    private function providerIsConfigured(string $provider): bool
    {
        $config = config("services.$provider");

        return is_array($config)
            && !empty($config['client_id'])
            && !empty($config['client_secret'])
            && !empty($config['redirect']);
    }

    private function fallbackEmail(string $provider, string $providerId): string
    {
        return $provider . '_' . $providerId . '@oauth.local';
    }
}
