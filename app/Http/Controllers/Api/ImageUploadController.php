<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Validation\ValidationException;

class ImageUploadController extends Controller
{
     public function upload(Request $request)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // 5MB max
                'width' => 'nullable|integer|min:50|max:2000',
                'height' => 'nullable|integer|min:50|max:2000',
                'maintain_aspect_ratio' => 'nullable|boolean',
            ]);

            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No image file provided',
                ], 400);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $width = $request->input('width', 800);
            $height = $request->input('height', 800);
            $maintainAspectRatio = $request->input('maintain_aspect_ratio', true);
            $imageIntervention = Image::read($image);

            if ($maintainAspectRatio) {
                $imageIntervention->scale(width: $width, height: $height);
            } else {
                $imageIntervention->resize($width, $height);
            }
            $path = 'images/' . $filename;
            Storage::disk('public')->put($path, $imageIntervention->encode());
            $fileSize = Storage::disk('public')->size($path);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded and resized successfully',
                'data' => [
                    'filename' => $filename,
                    'path' => $path,
                    'url' => asset('storage/' . $path),
                    'size' => $fileSize,
                    'dimensions' => [
                        'width' => $imageIntervention->width(),
                        'height' => $imageIntervention->height(),
                    ]
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
 
}
