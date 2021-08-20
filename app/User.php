<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
// use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable 
{
    use Notifiable, HasApiTokens, HasRoles, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [      
        'first_name', 
        'middle_name',
        'last_name',
		'email',
		'password',
		'social_type',
        'remember_token',
        'social_id',
        'is_deleted',
		'created_at',
		'updated_at',
		'status',
    ];
	
	public $sortable = [ 
		'id',
        'first_name', 
        'last_name',
		'email',
		'social_type',
		'created_at',
		'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
    public $timestamps = true;
	
	public function user_detail(){
	    return $this->hasOne(UserDetails::class);
	}
}
