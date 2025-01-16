<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\MainEntry;

class PDFController extends Controller
{
    public function generate(Request $request){
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        
        $pdf = PDF::loadView('myPDF', $data);    
        return $pdf->download('itsolutionstuff.pdf');        
    }
}
