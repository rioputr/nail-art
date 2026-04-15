<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController 
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:1024'
        ]);

        $data = $request->only('name', 'comment', 'rating');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->back()->with('success', 'Terima kasih atas testimoni Anda!');
    }
}
