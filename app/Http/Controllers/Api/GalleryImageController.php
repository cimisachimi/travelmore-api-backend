<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GalleryImage::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $file = $request->file('image');
        $filename = 'gallery/' . uniqid() . '.webp';

        // Convert, resize, and save the image as WebP
        $image_webp = Image::make($file)
            ->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
            }) // Optional: resize image
            ->encode('webp', 80); // 80% quality

        Storage::disk('public')->put($filename, (string) $image_webp);

        $galleryImage = GalleryImage::create([
            'title' => $validated['title'],
            'alt_text' => $validated['alt_text'] ?? $validated['title'],
            'image_path' => $filename,
        ]);

        return response()->json($galleryImage, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryImage $galleryImage)
    {
        return $galleryImage;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryImage $galleryImage)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $galleryImage->update($validated);

        return response()->json($galleryImage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryImage $galleryImage)
    {
        // Delete the image file from storage
        if (Storage::disk('public')->exists($galleryImage->image_path)) {
            Storage::disk('public')->delete($galleryImage->image_path);
        }
        
        // Delete the record from the database
        $galleryImage->delete();

        return response()->json(null, 204);
    }
}