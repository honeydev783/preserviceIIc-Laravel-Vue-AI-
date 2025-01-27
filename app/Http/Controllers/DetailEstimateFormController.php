<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobActivities;
use Session;
use Auth;
use PDF;
use App\Models\ActivityDescription;
use App\Models\ResourceComponents;
use App\Models\DetailEstimateForm;
use App\Models\Countries;
use App\Models\JobComponent;
use App\Models\Settings;

class DetailEstimateFormController extends Controller
{
    public function index(Request $request){   
       
        $data['id'] = 0;    
        return view('estimate_form.detail-form', compact('data'));
    }
    public function getDetailsIndex(Request $request){   
       
        return view('estimate_form.details-pdf');
    }
    public function lists(){

        $preliminries =   ResourceComponents::where('category','Preliminries')->get();     
        $labours =   ResourceComponents::where('category','Labour')->get();
        $equipments =   ResourceComponents::where('category','Equipment')->get();    
        $materials =   ResourceComponents::where('category','Material')->get(); 

        $data = [
            'preliminries' => $preliminries,  
            'labours' =>    $labours,
            'equipments' =>   $equipments, 
            'materials' =>  $materials
        ];
        return response()->json(['lists'=>$data],200);

    }

    public function getResults(Request $request){
       
        // $actives = JobActivities::where('category',$request->category)->orderByRaw("CONCAT(activity_code,' # ',position_order)")->get();
        $actives = JobActivities::where('category',$request->category)->orderByRaw("CAST(activity_code AS UNSIGNED) ASC")->get();
        $descriptions = ActivityDescription::orderBy('position_order','asc')->get();  
        $cat = ActivityDescription::find($request->category); 
        // 'get'   =>              
        $data = array(
            'actives'=>$actives,   
            'descriptions'=>$descriptions,
            'catego'   => $cat 
           
        );
        return response()->json(['data'=>$data]);
    }

    public function getInfo(Request $request,$type){        
        if($type == 'Components'){            
            
            $country = Countries::where('id', $request->country)->first();
           
            $active = JobActivities::where('id',$request->id)->whereRaw('FIND_IN_SET(?,country_id)', [$request->country])->first();            
            $currency = $country->currency;
            $exchange_rate = $country->exchange_rate;
            $lablour = 0;
            $equipment =0;
            $material =0;
            $job_components = array();
            if(!empty($active)){
                // $job_components = JobComponent::where('job_id', $active->id)->where('country_id', $request->country)->get();            
                $job_components = JobComponent::where('job_id', $active->id)->whereRaw('FIND_IN_SET(?,country_id)', [$request->country])->get();            
            }
            $components = [];
            foreach( $job_components as $key=>$res){
                
                if($res->component->category == 'Labour')
                {
                    $rate = ($res->component->rate * ($res->component->countrys->labour_rate / 100));
                }
                elseif($res->component->category == 'Equipment')
                {
                    $rate = ($res->component->rate * ($res->component->countrys->equipment_rate / 100));
                }
                elseif($res->component->category == 'Material')
                {
                    $rate = ($res->component->rate * ($res->component->countrys->material_rate / 100));
                }
                else{
                    $rate = $res->component->rate;
                }

                $components [] = [
                    'item'=>$key+1,
                    'id'=>$res->component->id,
                    'rate'=>$rate,
                    'quantity'=>$res->quantity,
                    'resource_type'=>$res->component->resource_type,
                    'unit'=>$res->component->unit,
                    'category'=>$res->component->category
                ];

                if($res->component->category == 'Labour'){
                    $lablour += $rate;
                }
                if($res->component->category == 'Equipment'){
                    $equipment += $lablour += $rate;
                }
                if($res->component->category == 'Material'){
                    $material += $lablour += $rate;;
                }
            }            
            
            $data = array(
                'components'=>$components,
                'labour' => $lablour,
                'material'=>$material,
                'equipment'=>$equipment,
                'currency'=>$currency,
                'exchange_rate'=>$exchange_rate
                
            );
            return response()->json(['data'=>$data],200);
        }
    }

    public function detailsGet($id, $country){

     
        $country = 2;
        $component = ResourceComponents::where('id',$id)->where('country', $country)->first();
        if(!empty($component))
        {
            if($component->category == 'Labour')
            {
                $rate = ($component->rate * ($component->countrys->labour_rate / 100));
            }
            elseif($component->category == 'Equipment')
            {
                $rate = ($component->rate * ($component->countrys->equipment_rate / 100));
            }
            elseif($component->category == 'Material')
            {
                $rate = ($component->rate * ($component->countrys->material_rate / 100));
            }
            else{
                $rate = $component->rate;
            }
            $component->rate = $rate;
            $components['id']=$component->id;
            $components['rate']=$rate;
            $components['quantity']=$component->quantity;
            $components['resource_type']=$component->resource_type;
            $components['unit']=$component->unit;
            $components['category']=$component->category;
        }
        else{
            $components = array();
        }
        return response()->json($component,200);
    }

    public function savePDF(Request $request){
       
        $data = Session::get('pdf-data');
        $input = $request->all();
 
     
        $temp_one_data['project_description']=empty( $input['project_description']) ? '': $input['project_description'];
        $temp_one_data['project_specification']=empty($input['project_specification'])? '':$input['project_specification'];
        $temp_one_data['owner']=empty($input['owner'])? '':$input['owner'];
        $temp_one_data['contractor']=empty($input['contractor'])? '':$input['contractor'];
        $temp_one_data['project_location'] = empty($input['project_location'])? '':$input['project_location'];
        $temp_one_data['estimate_type_sum']=empty($input['estimate_type_sum'])? '':$input['estimate_type_sum'];
        $temp_one_data['project_title']=empty($input['project_title_sum'])? '':$input['project_title_sum'];
        $temp_one_data['total_calculation']=empty($input['total_calculation'])? '':$input['total_calculation'];


        $temp_one_data['total_amout_sum']=empty($input['total_amout_sum'])? '':$input['total_amout_sum'];
        $temp_one_data['total_preliminary_sum']=empty($input['total_preliminary_sum'])? '':$input['total_preliminary_sum'];
        $temp_one_data['total_consistgency_sum']=empty($input['total_consistgency_sum'])? '':$input['total_consistgency_sum'];
        
       
        
        Session::put('detail-cost','');
        Session::put('detail-cost',$temp_one_data);
        return response()->json(Session::get('detail-cost'),200);
    }
    public function totalPDF(Request $request){
    
        $data = Session::get('detail-cost');         
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.detail-cost',$data)->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled'=>true,'enable_html5_parser'=>true]);;
        
     
        return $pdf->stream('detail-cost.pdf');
        
        return view('pdf.detail-cost',compact('data'));
    }

    public function saveForm(Request $request)
    {
        $form_detail = array(
            'form_name' => $request->form_name,
            'project_title' => $request->project_title,
            'estimate_type' => $request->estimate_type,
            'country' => $request->country,
            'activity_code' => $request->activity_code,
            'category' => $request->category,
            'activity_description' => $request->activity_description,
            'imperial_rate' => $request->imperial_rate,
            'quantity' => $request->quantity,
            'imperial_unit' => $request->imperial_unit,
            'metric_unit' => $request->metric_unit,
            'project_description' => $request->project_description,
            'labour_cost' => $request->labour_cost,
            'equipment_cost' => $request->equipment_cost,
            'material_cost' => $request->material_cost,
            'additional_cost' => $request->additional_cost,
            'sub_total' => $request->sub_total,
            'preliminary_percentage' => $request->preliminary_percentage,
            'preliminary_cost' => $request->preliminary_cost,
            'overhead_percentage' => $request->overhead_percentage,
            'overhead_cost' => $request->overhead_cost,
            'consistgency_percentage' => $request->consistgency_percentage,
            'consistgency_cost' => $request->consistgency_cost,
            'total_cost' => $request->total_cost,
            'project_note' => $request->project_note,
            'component_note' => $request->component_note,
            'components' => $request->components,
            'totalCalculation' => $request->totalCalculation,
            'metric_rate' => $request->metric_rate,
            'contractor' => $request->contractor,
            'owner' => $request->owner,
            'project_specification' => $request->project_specification,
        );
        $form_detail = json_encode($form_detail);
        
        if($request->id != 0)
        {
            $detail_estimate = DetailEstimateForm::where('id', $request->id)->first();
        }
        else{
            $detail_estimate = new DetailEstimateForm();
            $setting = Settings::first();
            if($setting->estimate_expiry_time != ''){
                $expiry_time = date("Y-m-d H:i:s",strtotime("+".$setting->estimate_expiry_time." minutes"));
                $detail_estimate->expiry_time = $expiry_time;
            }
        }        
        $detail_estimate->user_id = Auth::user()->id;        
        $detail_estimate->form_name = $request->form_name;
        $detail_estimate->form_details = $form_detail;
        $detail_estimate->save();
        return response()->json(['message'=>'Save Form Successfully.']);
    }

    public function formList(Request $request)
    {
        $costForms = DetailEstimateForm::where('user_id', Auth::user()->id)
                        ->orderBy('id','desc')
                        ->whereDate("expiry_time",">",date("Y-m-d H:i:s"))
                        ->paginate(10);
        return view('estimate_form.detail-form-list',compact('costForms'));
    }

    public function restoreForm($id)
    {
        $data['id'] = $id;    
        return view('estimate_form.detail-form', compact('data'));
    }

    public function getFormDetail(Request $request)
    {
        $detailForms = DetailEstimateForm::where('id', $request->id)->first();   
        $data['detailForms'] = $detailForms;
        return response()->json(['data'=>$data]);
    }

    public function destroy($id)
    {         
        DetailEstimateForm::find($id)->delete();
       return redirect()->route('detail_form_list')->with('success','Detail Estimate Form deleted successfully');
    }

    public function getCountry()
    {
        $countrys = Countries::where('id', '!=', 2)->orderBy('country_name', 'asc')->get();
        $data['countrys'] = $countrys;
        return response()->json(['data'=>$data],200);
    }

    public function getComponents(Request $request)
    {
        $id = 2;//$request->id;        
        $data['Preliminries'] = ResourceComponents::where('category','Preliminries')->where('country', $id)->orderBy('component_id', 'asc')->orderBy('id', 'desc')->get();     
        $data['Labour'] = ResourceComponents::where('category','Labour')->where('country', $id)->orderBy('component_id', 'asc')->orderBy('id', 'desc')->get();     
        $data['Equipment'] = ResourceComponents::where('category','Equipment')->where('country', $id)->orderBy('component_id', 'asc')->orderBy('id', 'desc')->get();     
        $data['Material'] = ResourceComponents::where('category','Material')->where('country', $id)->orderBy('component_id', 'asc')->orderBy('id', 'desc')->get();     
        return response()->json(['data'=>$data],200);
    }
    public function activity(Request $request)
    {
        $data['header'] = false;
        $data['sidebar'] = false;
        return view('estimate_form.activity', compact('data'));        
    }
    public function storeActivities(Request $request){
        $results = $request->input("results");
        $updated_from = $request->input("updated_from");
        $res['results'] = $results;
        $grid_show = $request->input("grid_show");
        $formdata = $request->input("formdata");
        \Session::put("activities",$results);
        \Session::put("formdata",$formdata);
        \Session::put("updated_from",$updated_from);
        \Session::put("grid_show",$grid_show);
        return response()->json($res);
    }
    public function fetchData(){
        $result = \Session::get("activities");
        $grid_show = \Session::get("grid_show");
        $updated_from = \Session::get("updated_from");
        $formdata = \Session::get("formdata");
        $res['results'] = $result;
        $res['formdata'] = $formdata;
        $res['updated_from'] = $updated_from;
        $res['grid_show'] = $grid_show;
        if(!empty($result)){
            $res['data_exists'] = true;
        }else{
            $res['data_exists'] = false;
        }
        // print_r(\Session::get("activities"));
        return response()->json($res);
    }
}
