<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController 
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured
        ]);

        return redirect()->back()->with('success', 'Status testimoni berhasil diperbarui');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimoni berhasil dihapus');
    }
}
