<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_admin',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'updated_at',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public static function validationRules()
    {
        return [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|regex:/@gmail.com$/|unique:users,email',
            'password' => 'required|string'
        ];
    }
    public static function validationMessages()
    {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a valid string.',
            'username.unique' => 'This username is not available. Please use a different username!',

            'email.required' => 'The email address is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.regex' => 'The email must be a Gmail address (e.g., example@gmail.com).',
            'email.unique' => 'There is already an account with this email. Please login or use a different one.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            
        ];
    }
}
