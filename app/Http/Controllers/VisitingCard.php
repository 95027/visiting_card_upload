<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class VisitingCard extends Controller
{
    public function store(Request $request){

        $data = $request->all();

        $data['user_id'] = auth()->user()->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('card_images', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Card::create($data);

        return redirect()->route('dashboard');
    }

// ...

public function extractTextFromImage(Request $request)
{

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');

        // Save the image to a temporary location
        $imagePath = $image->storeAs('temp_images', 'temp_image.png', 'public');

        // Use TesseractOCR to extract text from the image
        $tesseract = new TesseractOCR(storage_path("app/public/{$imagePath}"));
        $extractedText = $tesseract->run();

        // Parse the extracted text to get relevant information
        $name = $this->extractName($extractedText);
        $email = $this->extractEmail($extractedText);
        $phone = $this->extractPhone($extractedText);

        // Return the extracted data
        return response()->json([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);
    }

    return response()->json(['error' => 'Invalid image'], 400);
}

// Helper methods for extracting specific information using regular expressions
private function extractName($text)
{
    return 'sai';
}

private function extractEmail($text)
{
    return 'sai@example.com';
}

private function extractPhone($text)
{
    return '123456789';
}

}
