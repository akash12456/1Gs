<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory; 
    protected $guarded = []; 

    public function getImageAttribute()
    {
        return asset('admin-assets/uploads/affiliate/' . $this->attributes['image']);
    } 
    
    protected $appends = ['image'];
}
