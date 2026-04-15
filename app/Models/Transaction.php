<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_code', 'total_amount', 'status', 'shipping_address', 'payment_method', 'payment_receipt'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
     public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}