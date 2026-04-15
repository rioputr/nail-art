<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class DashboardController 
{
    public function index()
    {
        // 1. Stats Calculation
        $totalRevenue = Transaction::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_amount');
        $bookingsToday = Booking::whereDate('booking_date', Carbon::today())->count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // Stats growth simulation (placeholder or logic if needed)
        $stats = [
            'total_revenue' => $totalRevenue,
            'bookings_today' => $bookingsToday,
            'total_users' => $totalUsers,
            'pending_orders' => $pendingOrders,
        ];

        // 2. Recent Transactions (Orders)
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        // 3. Recent Bookings
        $recentBookings = Booking::latest()->take(5)->get();

        // 4. Trend Data (Last 14 Days)
        $chartLabels = [];
        $salesTrend = [];
        $bookingsTrend = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            
            // Sales
            $salesTrend[] = Transaction::whereIn('status', ['paid', 'shipped', 'completed'])
                                        ->whereDate('created_at', $date)
                                        ->sum('total_amount');
            
            // Bookings
            $bookingsTrend[] = Booking::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard.index', compact('stats', 'recentTransactions', 'recentBookings', 'chartLabels', 'salesTrend', 'bookingsTrend'));
    }
}
