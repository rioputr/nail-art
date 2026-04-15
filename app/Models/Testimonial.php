<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'comment',
        'rating',
        'avatar',
        'is_featured'
    ];
}
