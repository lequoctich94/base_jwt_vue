<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'm_staffs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_cd',
        'name',
        'email',
        'tel',
        'role',
        'title',
        'password',
        'service_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'staff_cd',
        'name',
        'email',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
	 * Get the user's full name.
	 *
	 * @return string
	 */
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

    /**
     * Get attribute email
     */
    public function getEmailAttribute($value)
    {
        $arr = explode('::', $value);
        if (count($arr) == 3) {
            return $arr[2];
        }
        return $value;
    }

    /**
     * Get attribute staff_cd
     */
    public function getStaffCdAttribute($value)
    {
        $arr = explode('::', $value);
        if (count($arr) == 3) {
            return $arr[2];
        }
        return $value;
    }
}
