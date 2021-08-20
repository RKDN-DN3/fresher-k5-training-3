<?php

namespace App\Models;

use App\Notifications\MailResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function taskTodo()
    {
        return $this->hasMany(TaskTodo::class);
    }
    public function sendPasswordResetNotification($token){
        $url = url( 'http://localhost:8080/reset-password/'.$token );
        $this->notify(new MailResetPasswordNotification($url));
    }

  /*   public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    } */
}
