<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyAccountOTP extends Model
{
    use HasFactory;
    protected $table = 'verify_account_otp';
    protected $fillable = ['email', 'phone', 'code'];
}
