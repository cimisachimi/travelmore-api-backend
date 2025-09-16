<?php

namespace App\Http\Controllers\Api;

// app/Http/Controllers/Api/TestimonialController.php

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() {
        return Testimonial::latest()->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'quote' => 'required|string',
        ]);
        $testimonial = Testimonial::create($validated);
        return response()->json($testimonial, 201);
    }

    public function show(Testimonial $testimonial) {
        return $testimonial;
    }

    public function update(Request $request, Testimonial $testimonial) {
        $validated = $request->validate([
            'author_name' => 'sometimes|required|string|max:255',
            'quote' => 'sometimes|required|string',
        ]);
        $testimonial->update($validated);
        return response()->json($testimonial);
    }

    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return response()->json(null, 204); // 204 No Content
    }
}