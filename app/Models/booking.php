<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'booking_date', 'booking_time', 'service_details', 'status', 'notes', 'estimated_price'];
    
    protected $casts = [
        'booking_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}