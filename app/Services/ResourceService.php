<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Countries;
use App\Models\ResourceComponents;
use Illuminate\Support\Facades\Log;
class ResourceService

{
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
        //$refinedPrompt = $this->processor->refinePrompt($request->text);
        $data = ["contents" => ["parts" => ["text" =>  $request->text]]];
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON response'], 500);
        }
        return json_decode($response, true); //convert to Array
        // return $token;
    }
    public function updateComponent($component)
    {
        $id = $component->id;
        $country_id = $component->country;
        $resource_type = $component->resource_type;
        $unit = $component->unit;
        try{
            $query1 = "detail description for " .$resource_type;
            $request = new Request([
                'text'   => $query1,
            ]);
            $response = $this->predict($request);
            //die($response);
            //echo gettype($response);
            $result = $response['candidates'][0]['content']['parts'][0]['text'];
    
            $query2 = "estimate average cost in USA per  " .$unit. " about " .$result;
            $request = new Request([
                'text'   => $query2,
            ]);
            $response = $this->predict($request);
            $result = $response['candidates'][0]['content']['parts'][0]['text'];
    
            $query3 = "get one average value in  " .$result;
            $request = new Request([
                'text'   => $query3,
            ]);
            $response = $this->predict($request);
            $result = $response['candidates'][0]['content']['parts'][0]['text'];
            $result = preg_replace('/[^0-9.]/', '', $result);
            $original_rate = (float) $result;
            $material_rate = Countries::where('id', $country_id)->first()->material_rate;
            $rate = (float) $material_rate * $original_rate;
            ResourceComponents::where('id', $id)->update(["rate" => $rate, "orignal_rate" => $original_rate]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        
    }
   
}
