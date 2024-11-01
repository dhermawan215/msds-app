<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserForgotPassword extends Model
{
    use HasFactory;

    protected $table = 'user_forgot_passwords';

    protected $fillable = ['email', 'token_change_password', 'token_expired_at'];
}
