<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Cloud\DocumentAI\V1\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\Document;
use Google\Cloud\DocumentAI\V1\BatchDocumentsInputConfig;

class DocumentController extends Controller
{
   public function showForm()
    {
        return view('upload');
    }

    public function uploadPDF(Request $request)
    {
        $fileName = time().'.pdf';       
        $request->file->move(public_path('entry_images'), $fileName);
        $path = url('/entry_images').'/'.$fileName;
        // Store the uploaded PDF
        // $path = $request->file('pdf_file')->store('uploads');

        // Call Google Document AI to process the PDF
        $projectId = '474073143471';
        $location = 'us'; // e.g., 'us' or 'eu'
        $processorId = '86a3094868132eb5';

        $client = new DocumentProcessorServiceClient([
            'credentials' => storage_path('VertexAIKey.json'),
        ]);

        $inputConfig = new BatchDocumentsInputConfig();
        // $inputConfig->setMimeType('application/pdf');
        // $inputConfig->setContent(file_get_contents($path));

        $document = new Document();
        // $document->setInputConfig($inputConfig);

        $request = new ProcessRequest();
        $request->setName("projects/$projectId/locations/$location/processors/$processorId");
        // $request->setRawDocument($document);

        try {
            // $response = $client->processDocument($request);
            return response()->json([
                'success' => true,
                'text' => 'LIGUANEA HOLDING LTD.',
                // 'text' => $response->getDocument()->getText(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

