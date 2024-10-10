<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Revenue extends Authenticatable
{
    use HasFactory;
   protected $guarded = [];
   protected $table = 'revenue';
   protected $guard = 'admin';

}
