<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Riipandi\LaravelOptiKey\Traits\HasUuidKey;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasUuidKey;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    protected $table = 'users';             // Model table name.
    protected $optiKeyFieldName = 'uuid';   // Laravel OptiKey field name.
    protected $perPage = 10;                // How much pagination rows.

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [ 'id', 'password', 'remember_token', ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Set username attribute to lowercase.
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    // Generate user avatar url.
    public function getAvatarAttribute($value): string
    {
        if (!$value) {
            return asset('images/avatars/avatar0.png');
        }

        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            return Storage::url('avatars/'.$value);
        }

        return $value;
    }
}
