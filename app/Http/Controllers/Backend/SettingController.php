<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\IntegrationSetting;
use Intervention\Image\Facades\Image;
use App\Models\SiteSetting;

class SettingController extends Controller
{
    public function SmtpSetting(){

        $smpt = SmtpSetting::first();

        if (!$smpt) {
            $smpt = SmtpSetting::create([
                'mailer' => 'smtp',
                'host' => 'smtp.mailtrap.io',
                'port' => '2525',
                'username' => null,
                'password' => null,
                'encryption' => 'tls',
                'from_address' => 'noreply@lms.com',
            ]);
        }

        return view('admin.backend.setting.smpt_update', compact('smpt'));

    }// End Method

    public function SmtpUpdate(Request $request){

        $smtp = SmtpSetting::first();

        if (!$smtp) {
            $smtp = SmtpSetting::create([]);
        }

        $updateData = [
            'mailer' =>  $request->mailer,
            'host' =>  $request->host,
            'port' =>  $request->port,
            'username' =>  $request->username,
            'encryption' =>  $request->encryption,
            'from_address' =>  $request->from_address,
        ];

        if (filled($request->password)) {
            $updateData['password'] = $request->password;
        }

        $smtp->update($updateData);

        $notification = array(
            'message' => 'Smtp Setting Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }// End Method


    public function SiteSetting(){

        $site = SiteSetting::first();

        if (!$site) {
            $site = SiteSetting::create([
                'logo' => null,
                'phone' => '+1 234 567 8900',
                'email' => 'support@lms.com',
                'address' => '123 Learning Street',
                'copyright' => '© 2026 LMS. All Rights Reserved.',
            ]);
        }

        return view('admin.backend.site.site_update', compact('site'));

    }// End Method

    public function UpdateSite(Request $request){

        $site = SiteSetting::first();

        if (!$site) {
            $site = SiteSetting::create([]);
        }

        if ($request->file('logo')) {

            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(140,41)->save('upload/logo/'.$name_gen);
            $save_url = 'upload/logo/'.$name_gen;

            $site->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'copyright' => $request->copyright,
                'logo' => $save_url,

            ]);

            $notification = array(
                'message' => 'Site Setting Updated with image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

        } else {

            $site->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'copyright' => $request->copyright,

            ]);

            $notification = array(
                'message' => 'Site Setting Updated without image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

        }

    }// End Method

    public function IntegrationSetting()
    {
        $integration = IntegrationSetting::first();

        if (!$integration) {
            $integration = IntegrationSetting::create([
                'google_client_id' => env('GOOGLE_CLIENT_ID'),
                'google_client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'google_redirect_uri' => env('GOOGLE_REDIRECT_URI', url('/auth/google/callback')),
                'stripe_key' => env('STRIPE_KEY'),
                'stripe_secret' => env('STRIPE_SECRET'),
            ]);
        }

        return view('admin.backend.setting.integration_update', compact('integration'));
    }

    public function IntegrationUpdate(Request $request)
    {
        $request->validate([
            'google_client_id' => 'nullable|string|max:1000',
            'google_client_secret' => 'nullable|string|max:2000',
            'google_redirect_uri' => 'nullable|url|max:1000',
            'stripe_key' => 'nullable|string|max:2000',
            'stripe_secret' => 'nullable|string|max:2000',
        ]);

        $integration = IntegrationSetting::first();
        if (!$integration) {
            $integration = IntegrationSetting::create([]);
        }

        $updateData = [
            'google_client_id' => $request->google_client_id,
            'google_redirect_uri' => $request->google_redirect_uri,
            'stripe_key' => $request->stripe_key,
        ];

        if (filled($request->google_client_secret)) {
            $updateData['google_client_secret'] = $request->google_client_secret;
        }

        if (filled($request->stripe_secret)) {
            $updateData['stripe_secret'] = $request->stripe_secret;
        }

        $integration->update($updateData);

        $notification = array(
            'message' => 'Integration Setting Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
