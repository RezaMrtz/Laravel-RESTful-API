<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /* Verification and Admin */
        const VERIFIED_USER = '1';
        const UNVERIFIED_USER = '0';

        const ADMIN_USER = 'true';
        const REGULAR_USER = 'false';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /* Transformer Model */
    public $transformer = UserTransformer::class;

    /* Protected Table */
    protected $table = 'users';

    /* Protected Dates */
    protected $dates = ['deleted_at'];

    /* Fillable */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* Accessors & Mutator */

    // Name
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    // Email
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = $email;
    }

    public function getEmailAttribute($email)
    {
        return $this->attributes['email'] = strtolower($email);
    }

    /* Methods */
    public function isAdmin()
    {
        $this->admin == User::ADMIN_USER;
    }

    public function isVerified()
    {
        $this->verified == User::VERIFIED_USER;
    }

    public static function generateVerificationCode()
    {
        $random = '0123456789abcdefghijklmnopqrstuvwxyz';

        return str_shuffle($random);
    }
}
