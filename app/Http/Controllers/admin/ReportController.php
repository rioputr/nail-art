<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController 
{
    public function index()
    {
        // 1. Stats Calculation
        $totalRevenue = Transaction::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_amount');
        
        // Calculate Monthly Booking Revenue (Confirmed Bookings)
        $monthlyBookingRevenue = Booking::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->where('status', 'confirmed')
                                        ->sum('estimated_price');

        $monthlyBookingsCount = Booking::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->count();

        $stats = [
            'total_revenue' => $totalRevenue,
            'monthly_booking_revenue' => $monthlyBookingRevenue,
            'monthly_bookings' => $monthlyBookingsCount,
        ];

        // 2. Chart Data (Last 6 Months)
        $months = [];
        $salesData = [];
        $bookingsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            // Sales for that month
            $sales = Transaction::whereIn('status', ['paid', 'shipped', 'completed'])
                                ->whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->sum('total_amount');
            $salesData[] = $sales;

            // Bookings for that month
            $bookings = Booking::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->count();
            $bookingsData[] = $bookings;
        }

        $chartData = [
            'sales' => [
                'labels' => $months,
                'data' => $salesData,
            ],
            'bookings' => [
                'labels' => $months,
                'data' => $bookingsData,
            ]
        ];

        return view('admin.reports.index', compact('stats', 'chartData'));
    }

    public function export()
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Type', 'Account Name', 'Amount', 'Status', 'Date']);

            // Get Transactions
            $transactions = Transaction::with('user')->latest()->get();
            foreach ($transactions as $t) {
                fputcsv($handle, [$t->transaction_code, 'Order', $t->user->name ?? 'Guest', $t->total_amount, $t->status, $t->created_at->format('Y-m-d')]);
            }

            // Get Bookings
            $bookings = Booking::latest()->get();
            foreach ($bookings as $b) {
                fputcsv($handle, ['BOOK-'.$b->id, 'Booking', $b->name, $b->estimated_price, $b->status, $b->created_at->format('Y-m-d')]);
            }

            fclose($handle);
        }, 'report_complete_' . date('Y-m-d') . '.csv');
    }
}
