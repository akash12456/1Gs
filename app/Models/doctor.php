<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'status',
        'phone_number',
        'gender',
        'language',
        'address',
        'specialization',
        'document1',
        'document2',
        'verifyStatus',
        'abaility',
        'specialty',
        'profilephoto',
    ];
}
