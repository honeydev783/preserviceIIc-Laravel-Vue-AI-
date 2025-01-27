<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainEntry;
use App\Models\User;
use App\Models\EntryImages;
use App\Models\RockValue;
use App\Models\ApproxEstimateForm;
use App\Models\Menus;
use App\Models\Countries;
use Session;
use Auth;
use PDF;
use App\Models\SoilConditions;
use App\Models\Settings;
class CostEstimateFormController extends Controller
{
   
    public function index(Request $request){         
        // echo $id; exit;
        $data['id'] = 0;    
        return view('estimate_form.cost-form', compact('data'));
    }

    public function getResults(Request $request){
        $elements = MainEntry::filter(request(['category']))->where(function($query) use ($request) {
            $query->whereRaw("FIND_IN_SET(?, country_id)", [$request->country]);
        })->orderBy('id','asc')->get();
        $total = 0 ;
        $country = Countries::where('id', $request->country)->first();
        $rock = RockValue::where('category',$request->category)->first();
        $category = Menus::where('id', $request->category)->first();
        $soil_condition = SoilConditions::where('category',$request->category)->first();
        $soil_condition_value = 0;
        if($request->soil_conditions == 1)
        {
            $soil_condition_value = $soil_condition->ordinary_soil;
        }
        else if($request->soil_conditions == 2)
        {
            $soil_condition_value = $soil_condition->sandy_soil;
        }
        else if($request->soil_conditions == 3)
        {
            $soil_condition_value = $soil_condition->loam_soil;
        }
        else if($request->soil_conditions == 4)
        {
            $soil_condition_value = $soil_condition->soft_clay_soil;
        }
        else if($request->soil_conditions == 5)
        {
            $soil_condition_value = $soil_condition->stiff_clay_soil;
        }
        else if($request->soil_conditions == 6)
        {
            $soil_condition_value = $soil_condition->hard_soil;
        }
        else if($request->soil_conditions == 7)
        {
            $soil_condition_value = $soil_condition->soft_soil;
        }
        $cost_sf_p = 0;
        $cost_m2_p = 0;
        $substructure = 0;
        $currency = $country->currency;
        $exchange_rate = $country->exchange_rate;
        foreach($elements as $element){
            $element->cost_sf = $country->labour_rate / 100.0 * $element->cost_sf/$exchange_rate;
            $element->cost_m2 = floor($element->cost_sf * 100) / 100 * 10.7639;
            if(!empty($request->quantity_sq_ft)) $element->element_cost = $element->cost_sf * $request->quantity_sq_ft;
            else $element->element_cost = 0 ;
            // if(!empty($request->num_unit)) $element->element_cost = $element->element_cost*$request->num_unit;
            // if(!empty($request->num_story)){
            //     if(!$element->is_story)
            //         $element->element_cost = $element->element_cost*$request->num_story;
            // }    
            // $rock_cost = $rock->rock_value * $request->rock_percent/100;
            if($element->element_code === '02'){
                // $element->element_cost += $rock_cost;
                $cost_sf_p = ($element->cost_sf * $rock->rock_value) / 100;
                $cost_sf_p = ($cost_sf_p * $request->rock_percent ) / 100;
                // if($request->rock_percent != 0)
                // {
                //     $cost_sf_p = ($element->cost_sf * 12.94) / $request->rock_percent;
                // }
                // else{
                //     $cost_sf_p = ($element->cost_sf * 12.94);
                // }
                if($element->description = 'substructure')
                {   
                    $r =  ($rock->rock_value * $request->rock_percent) / 100;               
                    $element->cost_sf = $r + $soil_condition_value + $element->cost_sf;
                }
                else
                {
                    $element->cost_sf = $element->cost_sf + $cost_sf_p;
                }
                // $element->cost_sf = $request->quantity_sq_ft == 0? 0 : $element->element_cost/$request->quantity_sq_ft;
                $element->cost_m2 = $element->cost_sf * 10.7639;
                $element->element_cost = $element->cost_sf * $request->quantity_sq_ft; 
            }
            if(!empty($request->num_unit)) $element->element_cost = $element->element_cost*$request->num_unit;
            if(!empty($request->num_story)){
                if(!$element->is_story)
                    $element->element_cost = $element->element_cost*$request->num_story;
            }
            $total += $element->element_cost;
        }
        // echo '<pre>'; print_r($elements); exit;
        $total_factor = 0 ;
        foreach($elements as $element){
            $element->factor = $total == 0 ? 0 : round($element->element_cost/$total,4)*100;
            $element->factor_type = number_format($element->factor,2).' %';
            $total_factor += $element->factor;
        }
        $t_unit_cost = 0;
        if(!empty($request->num_unit)) $t_unit_cost = round($total/$request->num_unit,5);
        $image_src = url('/entry_images/default.png');
        $image = EntryImages::where('category',$request->category)->first();
        if(!empty($image)) $image_src = url('/entry_images').'/'.$image->image_name;
        
        $cost_gross = $request->quantity_sq_ft * $request->num_unit * $request->num_story ;
        
        $cost_sf = 0 ;
        if($cost_gross != 0) $cost_sf = round($total/$cost_gross,2);
        
        $cost_m2 = 0 ;
        $cost_m2 = $cost_sf*10.7639;
        
        
        $data = array(
            'elements'=>$elements,
            'total'=>$total,
            't_unit_cost'=>$t_unit_cost,
            'image_src'=>$image_src,
            'total_factor'=>number_format($total_factor,2).' %',
            'e_cost_sf'=>$cost_sf,
            'e_cost_m2'=>$cost_m2,
            'cost_gross'=>$cost_gross,
            'num_unit'=>$request->num_unit,
            'quantity_sq_ft'=>$request->quantity_sq_ft,
            'num_story'=>$request->num_story,
            'category'=>$request->category,
            'rock_percent'=>$request->rock_percent,
            'category_name'=>$category->menu_name,
            'currency'=>$currency,
            'exchange_rate'=>$exchange_rate
        );
        Session::put('pdf_data','');
        Session::put('pdf-data',$data);
        return response()->json(['data'=>$data],200);
    }
    
    public function savePDF(Request $request){
        $data = Session::get('pdf-data');
        $temp_data = $data;
        $temp_data['project_title'] = empty($request->project_title) ? '':$request->project_title;
        $temp_data['country'] =  empty($request->country) ? '':$request->country;
        $temp_data['contract_sum'] = $request->contract_sum;
        $temp_data['project_cost'] = $request->project_cost ;
        $temp_data['description'] = empty($request->description) ? '':$request->description;    
        $temp_data['total_cost'] = $request->total_cost; 
        $temp_data['per_main_preliminary'] = $request->per_main_preliminary;
        $temp_data['main_preliminary'] = $request->main_preliminary;
        $temp_data['per_main_profit'] = $request->per_main_profit;
        $temp_data['main_profit'] = $request->main_profit;
        $temp_data['per_team_fee'] = $request->per_team_fee;
        $temp_data['team_fee'] = $request->team_fee;
        $temp_data['per_dev_cost'] = $request->per_dev_cost;
        $temp_data['dev_cost'] = $request->dev_cost;
        $temp_data['cost_sf'] = $request->cost_sf;
        $temp_data['cost_m2'] = $request->cost_m2;        
        $temp_data['per_client_risk'] = $request->per_client_risk;
        $temp_data['client_risk'] = $request->client_risk;
        $temp_data['conceptual_note'] = empty($request->conceptual_note) ? '':$request->conceptual_note; 
        $temp_data['estimate_note'] = empty($request->estimate_note) ? '':$request->estimate_note; 
        $temp_data['exculstion_note'] = empty($request->exculstion_note) ? '':$request->exculstion_note; 
        Session::put('pdf-temp-data','');
        Session::put('pdf-temp-data',$temp_data);
        return response()->json(200);
    }

    public function printPDF(Request $request){
        $data = Session::get('pdf-temp-data');         
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.estimate-form',$data)->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled'=>true,'enable_html5_parser'=>true]);;
        return $pdf->stream('estimate-form.pdf');
        return view('pdf.estimate-form',compact('data'));
    }

    public function saveForm(Request $request)
    {

        $form_detail = array(
            'project_title' => $request->project_title,
            'category' => $request->category,
            'country' => $request->country,
            'quantity_sq_ft' => $request->quantity_sq_ft,
            'num_unit' => $request->num_unit,
            'num_story' => $request->num_story,
            'contract_sum' => $request->contract_sum,
            'e_cost_sf' => $request->e_cost_sf,
            'e_cost_m2' => $request->e_cost_m2,
            'project_cost' => $request->project_cost,
            'cost_sf' => $request->cost_sf,
            'cost_m2' => $request->cost_m2,
            'description' => $request->description,
            'cost_gross' => $request->cost_gross,
            'rock_percent' => $request->rock_percent,
            't_unit_cost' => $request->t_unit_cost,
            'total_cost' => $request->total_cost,
            'conceptual_note' => $request->conceptual_note,
            'estimate_note' => $request->estimate_note,
            'exculstion_note' => $request->exculstion_note,
            'per_main_preliminary' => $request->per_main_preliminary,
            'main_preliminary_collect' => $request->main_preliminary_collect,
            'per_main_profit' => $request->per_main_profit,
            'main_profit_collect' => $request->main_profit_collect,
            'contract_sum_collect' => $request->contract_sum_collect,
            'per_team_fee' => $request->per_team_fee,
            'team_fee_collect' => $request->team_fee_collect,
            'per_dev_cost' => $request->per_dev_cost,
            'dev_cost_collect' => $request->dev_cost_collect,
            'per_client_risk' => $request->per_client_risk,
            'client_risk_collect' => $request->client_risk_collect,
            'project_cost' => $request->project_cost
        );
        $form_detail = json_encode($form_detail);
        
        if($request->id != 0)
        {
            $approx_estimate = ApproxEstimateForm::where('id', $request->id)->first();
        }
        else{
            $approx_estimate = new ApproxEstimateForm();
            $setting = Settings::first();
            if($setting->estimate_expiry_time != ''){
                $expiry_time = date("Y-m-d H:i:s",strtotime("+".$setting->estimate_expiry_time." minutes"));
                $approx_estimate->expiry_time = $expiry_time;
            }
        }        
        $approx_estimate->user_id = Auth::user()->id;        
        $approx_estimate->form_name = $request->form_name;
        $approx_estimate->form_details = $form_detail;
        $approx_estimate->save();
        return response()->json(['message'=>'Save Form Successfully.']);
    }

    public function formList(Request $request)
    {
        $costForms = ApproxEstimateForm::where('user_id', Auth::user()->id)
                                    ->orderBy('id','desc')
                                    ->whereDate("expiry_time",">",date("Y-m-d H:i:s"))
                                    ->paginate(10);
        return view('estimate_form.cost-form-list',compact('costForms'));
    }

    public function restoreForm($id)
    {
        $data['id'] = $id;    
        return view('estimate_form.cost-form', compact('data'));
    }

    public function getFormDetail(Request $request)
    {
        $costForms = ApproxEstimateForm::where('id', $request->id)->first();   
        $data['costForms'] = $costForms;
        return response()->json(['data'=>$data]);
    }

    public function destroy($id)
    {         
        ApproxEstimateForm::find($id)->delete();
       return redirect()->route('approx_form_list')->with('success','Approx Estimate Form deleted successfully');
    }

    public function getEstimateType()
    {
        $menus = Menus::all();
        $data['menus'] = $menus;
        return response()->json(['data'=>$data],200);
    }

    public function getCountry()
    {
        $countrys = Countries::all();
        $data['countrys'] = $countrys;
        return response()->json(['data'=>$data],200);
    }
}
