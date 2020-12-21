<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{
    use HasFactory;

    protected $table = "user_device_tokens";

    protected $fillable = [
        "user_id", "device_token", "device_id", "device_type", "token_status"
    ];
}
