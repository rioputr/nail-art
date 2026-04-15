<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $admin = User::where('role', 'admin')->first();

        $services = [
            'Basic Manicure' => 150000,
            'Gel Polish' => 200000,
            'Nail Art Design' => 350000,
            'Nail Extensions' => 500000,
        ];

        // Create 30 random bookings
        for ($i = 0; $i < 30; $i++) {
            $serviceName = array_rand($services);
            $price = $services[$serviceName];
            
            // Random date between -1 month and +1 month
            $date = Carbon::now()->subDays(rand(-30, 30));
            $time = rand(9, 17) . ':00';

            // Random status weighted towards completed for past dates
            $status = 'pending';
            if ($date->isPast()) {
                $status = (rand(1, 10) > 2) ? 'confirmed' : 'cancelled'; // mostly confirmed
            } else {
                $status = (rand(1, 10) > 5) ? 'pending' : 'confirmed';
            }

            // Random User or Guest (null)
            $user = (rand(0, 1) === 1 && $users->count() > 0) ? $users->random() : null;

            Booking::create([
                'user_id' => $user ? $user->id : null,
                'name' => $user ? $user->name : 'Guest Customer ' . ($i + 1),
                'email' => $user ? $user->email : 'guest'.$i.'@example.com',
                'phone' => $user?->phone ?? '0812345678'.$i,
                'booking_date' => $date->format('Y-m-d'),
                'booking_time' => $time,
                'service_details' => $serviceName,
                'status' => $status,
                'notes' => (rand(0, 3) === 3) ? 'Alergi terhadap lateks.' : null,
                'estimated_price' => $price,
            ]);
        }
    }
}
