<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    protected $table = "mail_templates";

    protected $fillable = [
        "title", "content", "code", "blade_path", "attachment_path", "created_by", "updated_by"
    ];
}
