<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'name' => 'Karen M.',
                'comment' => 'Sangat puas dengan hasilnya! Nail art-nya rapi dan tahan lama. Pelayanan juga ramah dan profesional. Highly recommended!',
                'rating' => 5,
                'is_featured' => true
            ],
            [
                'name' => 'Jessica W.',
                'comment' => 'Tempatnya nyaman banget, mbaknya telaten pengerjaannya. Hasilnya sesuai request! Sukses terus Caroline Nail Art.',
                'rating' => 5,
                'is_featured' => true
            ],
            [
                'name' => 'Amanda P.',
                'comment' => 'Udah langganan di sini. Pelayanannya gak pernah mengecewakan. Harganya juga affordable banget buat kualitas segini.',
                'rating' => 5,
                'is_featured' => true
            ],
            [
                'name' => 'Siska K.',
                'comment' => 'Baru pertama kali coba dan langsung suka! Detail banget pengerjaannya.',
                'rating' => 4,
                'is_featured' => false
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
