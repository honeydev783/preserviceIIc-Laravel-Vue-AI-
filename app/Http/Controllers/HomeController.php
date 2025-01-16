<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ApproxEstimateForm;
use App\Models\DetailEstimateForm;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $detail_forms = array();
        $approx_forms = array();
        if(\Session::get("exp_detail_forms")){
            $exp_detail_forms = \Session::get("exp_detail_forms");
            $exp_detail_forms = explode(",",\Session::get("exp_detail_forms"));
            $detail_forms = DetailEstimateForm::whereIn("id",$exp_detail_forms)->get();
            \Session::forget("exp_detail_forms");
        }else{
            $exp_detail_forms = array();
        }
        $approx_forms = ApproxEstimateForm::where("expiry_time","<",date("Y-m-d H:i:s"))->get();

        if(\Session::get("exp_approx_forms")){
            $exp_approx_forms = explode(",",\Session::get("exp_approx_forms"));
            $approx_forms = ApproxEstimateForm::whereIn("id",$exp_approx_forms)->get();
            \Session::forget("exp_approx_forms");
        }else{
            $exp_approx_forms = array();
        }
        $view_data['exp_detail_forms'] = $exp_detail_forms;
        $view_data['exp_approx_forms'] = $exp_approx_forms;
       
        $view_data['detail_forms'] = $detail_forms;
        $view_data['approx_forms'] = $approx_forms;
        
        return view('dashboard',$view_data);
    }
}
