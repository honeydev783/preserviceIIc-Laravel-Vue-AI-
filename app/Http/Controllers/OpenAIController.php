<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class OpenAIController extends Controller
{
    public function predictimages(Request $request)
    {
        // Validate user input
        $request->validate([
            'text' => 'required|string|max:1000',
        ]);

        $prompt = $request->text;
        $prompt = str_replace('"#', '', $prompt);
        $apiKey = env('OPENAI_API_KEY'); // Store your API key in .env file

        // OpenAI API URL for image generation
        $url = 'https://api.openai.com/v1/images/generations';

        try {
            // Create a Guzzle client
            $client = new Client();

            // Send POST request to OpenAI API
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    "model"=> "dall-e-3",
                    'prompt' => $prompt,
                    'n' => 1, // Number of images to generate
                    'size' => '1024x1024', // Image size
                ],
            ]);

            // Decode the JSON response
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Get the image URL
            $imageUrl = $responseBody['data'][0]['url'];
            
            $fetch_response = Http::get($imageUrl);
            if ($fetch_response->successful()) {
                // Step 3: Get the image content
                $imageContent = $fetch_response->body();
                $imagetexts = "";
                // Step 4: Define the file name and path
                $fileName = uniqid() . '.png'; // Create a unique file name
                $filePath = 'public/Images/' . $fileName; // Directory path (inside public/images)
                if (file_put_contents($filePath, $imageContent)) {
                    $imagetexts = $imagetexts . '<img src="../' . $filePath . '" alt="Base64 Image" style="width: 100%;" />';
                    
                } else {
                    return 'Failed to save image.';
                }
            // Return the generated image URL
            } 
        }catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
        return $imagetexts;
        
    }
}
