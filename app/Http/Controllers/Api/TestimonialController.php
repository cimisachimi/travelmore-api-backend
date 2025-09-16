<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Testimonial::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'quote' => 'required|string',
        ]);

        $testimonial = Testimonial::create($validated);

        return response()->json($testimonial, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return $testimonial;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'author_name' => 'sometimes|required|string|max:255',
            'quote' => 'sometimes|required|string',
        ]);

        $testimonial->update($validated);

        return response()->json($testimonial);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json(null, 204); // 204 No Content
    }
}