<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey='user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'user_email',
        'user_document',
        'user_birthday',
    ];


    protected $appends=[
        'encid',
    ];

    protected $hidden=[
        'user_id',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_name' => 'encrypted',
        'user_email' => 'encrypted',
        'user_document'=>'encrypted',
        'user_birthday'=>'encrypted',
    ];


    public function getEncidAttribute()
    {
        return Crypt::encryptString($this->user_id);
    }
}
