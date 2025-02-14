<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ProcessStatus;
use Illuminate\Support\Facades\DB;
use App\Models\Countries;
use App\Models\ResourceComponents;
use Illuminate\Support\Facades\Log;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client;
use Illuminate\Http\Request;
use App\Services\ResourceService;

class UpdateResourceComponentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle(ResourceService $resourceService)
    {
        set_time_limit(0);
        while (true) {
            // Check if the process should continue
            
            $status = ProcessStatus::first();
            if (!$status || !$status->is_running) {
                break; // Stop the job if flag is false
            }

            // $rand_id = rand(1, 47151);
            $component_1 = DB::table('resource_components')->where('category', 'Material')->where('id', '>', 1)->get();
            // $component_2 = DB::table('resource_components')->where('category', 'Material')->where('id', '>', $rand_id)->get();

            foreach ($component_1 as $component) {
                
                try {
                    $this->updateComponent($component);
                } catch (\Exception $e) {
                    continue;
                }
                sleep(5);
                $status = ProcessStatus::first();
                if (!$status || !$status->is_running) {
                    break; // Stop the job if flag is false
                }
                // Prevent excessive CPU usage
            }
        }
    }
    public function predict(Request $request)
    {
        set_time_limit(0);
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

        try {
            $response = curl_exec($ch);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

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
    {   set_time_limit(0);
        $id = $component->id;
        $country_id = $component->country;
        $resource_type = $component->resource_type;
        $unit = $component->unit;
        try {
            $query1 = "detail description for " . $resource_type;
            $request = new Request([
                'text'   => $query1,
            ]);
            $response = $this->predict($request);
            //die($response);
            //echo gettype($response);
            $result = $response['candidates'][0]['content']['parts'][0]['text'];

            $query2 = "estimate average cost in USA per  " . $unit . " about " . $result;
            $request = new Request([
                'text'   => $query2,
            ]);
            $response = $this->predict($request);
            $result = $response['candidates'][0]['content']['parts'][0]['text'];

            $query3 = "get one average value in  " . $result;
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
