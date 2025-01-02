<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class IntegrationSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setGoogleClientIdAttribute($value): void
    {
        $this->attributes['google_client_id'] = $this->encryptOrNull($value);
    }

    public function getGoogleClientIdAttribute($value): ?string
    {
        return $this->decryptOrRaw($value);
    }

    public function setGoogleClientSecretAttribute($value): void
    {
        $this->attributes['google_client_secret'] = $this->encryptOrNull($value);
    }

    public function getGoogleClientSecretAttribute($value): ?string
    {
        return $this->decryptOrRaw($value);
    }

    public function setStripeKeyAttribute($value): void
    {
        $this->attributes['stripe_key'] = $this->encryptOrNull($value);
    }

    public function getStripeKeyAttribute($value): ?string
    {
        return $this->decryptOrRaw($value);
    }

    public function setStripeSecretAttribute($value): void
    {
        $this->attributes['stripe_secret'] = $this->encryptOrNull($value);
    }

    public function getStripeSecretAttribute($value): ?string
    {
        return $this->decryptOrRaw($value);
    }

    private function encryptOrNull($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return Crypt::encryptString((string) $value);
    }

    private function decryptOrRaw($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $th) {
            // Backward compatibility for non-encrypted legacy values.
            return $value;
        }
    }
}
