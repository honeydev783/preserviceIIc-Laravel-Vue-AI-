<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ApproxEstimateForm;
use App\Models\DetailEstimateForm;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function expireEsitmate()
    {
        $current_date = date("Y-m-d H:i:s");
        $detail_forms = DetailEstimateForm::where("expiry_time","<",$current_date)->delete();
        $approx_forms = ApproxEstimateForm::where("expiry_time","<",$current_date)->delete();
    }
}
