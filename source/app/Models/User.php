<?php

namespace App\Models;

use App\Casts\DateTimeString;
use App\Casts\PasswordCast;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    const MALE = 'M';
    const FEMALE = 'F';
    const GENDER = [self::FEMALE, self::MALE];

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => DateTimeString::class,
        'updated_at' => DateTimeString::class,
        'password' => PasswordCast::class,
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'version'  => 'beta 0.0.1',
            'homework' => 'idus'
        ];
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id')
            ->orderBy('settlement_at');
    }
}
