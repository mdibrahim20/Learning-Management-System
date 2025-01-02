<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SmtpSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function setPasswordAttribute($value): void
    {
        if (blank($value)) {
            $this->attributes['password'] = null;
            return;
        }

        $this->attributes['password'] = Crypt::encryptString((string) $value);
    }

    public function getPasswordAttribute($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $th) {
            // Backward compatibility for old plain-text entries.
            return $value;
        }
    }
}
