<?php

namespace App\Models;
use App\Models\Booking;
use App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; //SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'is_admin',
        'status',
        'phone',
        'address',
        'avatar',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar)
            : "https://ui-avatars.com/api/?name=" . urlencode($this->name);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getRoleLabelAttribute()
    {
        return ucfirst($this->role);
    }

      public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}