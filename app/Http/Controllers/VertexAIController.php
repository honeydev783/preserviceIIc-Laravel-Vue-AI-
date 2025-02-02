<?php

namespace App\Http\Controllers;

// use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\PromptProcessor;
class VertexAIController extends Controller
{
    protected $processor;

    public function __construct(PromptProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function predict(Request $request)
    {
        // Prepare the HTTP client
        $client = new Client();

        // Get the access token
        $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];

        $credentials = new ServiceAccountCredentials($scopes, $credentialsPath);
        $token = $credentials->fetchAuthToken()['access_token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.0-pro:generateContent?key=AIzaSyB_lCA_IkBmaH4hOMdtL2erpwD-oLfAg1A");
        curl_setopt($ch, CURLOPT_POST, true); // Change to false if GET
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = ["contents" => ["parts" => ["text" => $request->text]]];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        //$response = json_decode($response);
        $responseData = json_decode($response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON response'], 500);
        }
        try {
           
            $filePath = 'jsonl_files/dataset.jsonl';
            $fileHandle = fopen($filePath, 'a');
            $text = $responseData->candidates[0]->content->parts[0]->text;
            $input = trim($request->text);
            // Safely extract text from the response object
            $save_data = [
                "input" => $input,
                "output" => $text ?? ''
            ];

            // Convert the array to JSON and write it to the file
            fwrite($fileHandle, json_encode($save_data) . PHP_EOL);
            fclose($fileHandle);
            
        } catch (\Exception $e) {
        Log::error("error===>".$e->getMessage());
           
        }


        return response()->json(json_decode($response));
        // return $token;
    }

    public function predictimages(Request $request)
    {
        $keyFilePath = env('GOOGLE_APPLICATION_CREDENTIALS');
        $client = new Client();

        $client->setAuthConfig($keyFilePath);
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');

        // Check if the token is expired and refresh if needed
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithAssertion();
        }

        $accessToken = $client->getAccessToken()['access_token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://us-central1-aiplatform.googleapis.com/v1/projects/474073143471/locations/us-central1/publishers/google/models/imagen-3.0-generate-002:predict");
        curl_setopt($ch, CURLOPT_POST, true); // Change to false if GET
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $prompt = $request->text;
        //Log::error("error===>".$prompt);
        $refinedPrompt = $this->processor->refinePrompt($prompt);
        $data = ["instances" => ["prompt" => $refinedPrompt], "parameters" => ["sampleCount" => 1, "aspectRatio" => '4:3']];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        Log::error("error===>".$response);
        $aidata = json_decode($response, true);
        
        $airesult = $aidata['predictions'];
        $imagetexts = "";
        foreach ($airesult as $key => $value) {
            $filetype = $value['mimeType'];
            $filevalue = $value['bytesBase64Encoded'];
            $base64Image = 'data:' . $filetype . ';base64,' . $filevalue;
            // $imagetexts = $imagetexts.'<img src="'.$base64Image.'" alt="Base64 Image" style="max-width: 250px;" />';
            $filename = uniqid() . '.png';
            $filePath = 'public/Images/' . $filename;
            $data = base64_decode($filevalue);
            // Save the image to the specified directory
            if (file_put_contents($filePath, $data)) {
                $imagetexts = $imagetexts . '<img src="../' . $filePath . '" alt="Base64 Image" style="width: 100%;" />';
                
            } else {
                return 'Failed to save image.';
            }
        }
        // // return $response;
        return $imagetexts;
    }
}
