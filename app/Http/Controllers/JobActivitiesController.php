<?php

namespace App\Http\Controllers;

use App\Models\JobActivities;
use Illuminate\Http\Request;
use Session;
use App\Models\ActivityDescription;
use App\Models\JobComponent;
use App\Models\ResourceComponents;
use App\Models\Countries;

class JobActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        // $actives = JobActivities::orderBy('id', 'asc')->get();
        // $i = 1;
        // foreach($actives as $active)
        // {
        //     $act = JobActivities::find($active->id);
        //     $act->position_order = $i;
        //     $act->save();
        //     $i++;
        // }
        // echo 'scuuess'; exit;
        // $actives = JobActivities::orderBy('id','desc')->paginate(50);
        
        $sort_by = 'position_order';
        if($request->get("sort_by")){
            $sort_by = $request->get("sort_by");
        }
        if(isset($request->activity) && !empty($request->activity))
        {
            $activity_code = $request->activity; 
        }
        
        if(isset($request->activity) && !empty($request->activity))
        {
            $activity_code = $request->activity; 
        }
        else{
            $activity_code = '';
        }
        if(!empty($activity_code))
        {
            
            $actives = JobActivities::orderByRaw("CAST(".$sort_by." AS UNSIGNED) DESC")->where('activity_code', $request->activity)->paginate(50);
        }else{
            $actives = JobActivities::orderByRaw("CAST(".$sort_by." AS UNSIGNED) DESC")->paginate(50);
        }
        foreach($actives as $active){
            $category = ActivityDescription::find($active->category);
            if(!empty($category)) $active->category_name = $category->title;
            else $active->category_name = '';
        }
        return view('job_activities.index',compact('actives', 'activity_code','sort_by'));
    }

    public function global()
    {
        $countries = Countries::orderBy('id','desc')->get();
        return view('job_activities.global',compact('countries'));
    }

    public function globalUpdate(Request $request)
    {
        if (isset($request->country)) {
            JobActivities::query()->update(['country_id' => implode(',', $request->country)]);
            JobComponent::query()->update(['country_id' => implode(',', $request->country)]);
        }
        return redirect()->route('job_activities.index')->with('success','Successfully updated globally.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = ResourceComponents::orderBy('component_id','asc')->get();
        $descriptions = ActivityDescription::orderBy('title','asc')->get();
        $countries = Countries::orderBy('id','desc')->get();
        return view('job_activities.create',compact('descriptions','components', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'description' => 'required',
            'category' => 'required',            
            'activity_code' => 'required',  
            'addmore'=>'required',
            'imperial_unit'=>'required',
            'conversion_factor'=>'required',
            'metric_unit'=>'required',
            'country' => 'required'     
        ]);

    //    echo '<pre>'; print_r($request->country); exit;

        // $component_ids = ResourceComponents::whereIn('id',$request->components)->pluck('component_id')->toArray();
        // $name_list = implode(', ',$component_ids);
        // $components = implode(',',$request->components);
       
        $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
       $output = JobActivities::create([
            'description' => $request->description,
            'category' => $request->category,            
            'activity_code' => $request->activity_code,
            'imperial_unit'=>$request->imperial_unit,
            'conservation_factor'=>$request->conversion_factor,
            'metric_unit'=>$request->metric_unit,
           'country_id' => implode(',', $request->country),
           'position_order' => $position_order->position_order + 1
        ]);
        //  $output->id = 275;
        
        $input = array();        
        // foreach($request->addmore as $k => $values){  // each job component has same countries
            $values = $request->addmore[0];
            foreach($values as $value)
            {
                if ($value['component_id'] != '' && $value['quantity'] != '') {
                    $input[] = [
                        'component_id'=>$value['component_id'],
                        'quantity'=>$value['quantity'],
                        'job_id'=>$output->id,
                        'country_id'=>implode(',', $request->country)
                        // 'country_id'=>$k
                    ];
                }
            }
        // }          
        JobComponent::where('job_id',$output->id)->delete();
       JobComponent::insert( $input);
        return redirect()->route('job_activities.index')->with('success','Successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobActivities  $jobActivities
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
   
       $jobActivities = JobActivities::find($id);
       return response()->json(['success'=>true,'data'=>$jobActivities],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobActivities  $jobActivities
     * @return \Illuminate\Http\Response
     */
    public function edit(JobActivities $job_activity)
    {        
        $components = ResourceComponents::orderBy('component_id','asc')->get();
        $descriptions = ActivityDescription::orderBy('title','asc')->get();        
        $component_ids = explode(',',$job_activity->components);
        $countries = Countries::orderBy('id','desc')->get();
        $job_components = JobComponent::where('job_id', $job_activity->id)->get()->toArray();

        $job_component_data = $job_components; //array();
        $country_ids = array();
        $i = 0;
        // foreach($job_components as $k => $job_component)
        // {
        //     if(!in_array($job_component['country_id'], $country_ids))
        //     {
        //         $country_ids[] = $job_component['country_id'];
        //         $country = Countries::where('id', $job_component['country_id'])->first()->toArray();
        //         $job_component_data[$k]['country'] = $country;                                
        //         $job_component_data[$k]['detail'][] = $job_component;
        //         $i = $k;
        //     }
        //     else{
        //         $job_component_data[$i]['detail'][] = $job_component;
        //     }            
        // }        
        return view('job_activities.edit',compact('job_activity','descriptions','components','component_ids', 'countries', 'job_component_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobActivities  $jobActivities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobActivities $job_activity)
    {
       
        $request->validate([
            'description' => 'required',
            'category' => 'required',          
            'activity_code' => 'required',    
            'addmore'=>'required',   
            'imperial_unit'=>'required',
            'conservation_factor'=>'required',
            'metric_unit'=>'required',
            'country' =>'required',
        ]);     
                

        $data = array(
            'description' => $request->description,
            'category' => $request->category,            
            'activity_code' => $request->activity_code,  
            'imperial_unit'=>$request->imperial_unit,
            'conservation_factor'=>$request->conservation_factor,
            'metric_unit'=>$request->metric_unit,
            'country_id' => implode(',',$request->country)
        );
        
        $job_activity->update($data);


        $input = [];
        // foreach($request->addmore as $k => $values){ // each job component has same countries
           $values = $request->addmore[0];
            foreach($values as $value)
            {
                if ($value['component_id'] != '' && $value['quantity'] != '')
                $input[] = [
                    'component_id'=>$value['component_id'],
                    'quantity'=>$value['quantity'],
                    'job_id'=>$job_activity->id,
                    'country_id'=>implode(',',$request->country)
                    // 'country_id'=>$k
                ];
            }
        // }
        
          JobComponent::where('job_id',$job_activity->id)->delete();

          JobComponent::insert( $input);
        return redirect()->route('job_activities.index')
            ->with('success', 'Activity updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobActivities  $jobActivities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {         
        $job_activity = JobActivities::find($id);
        // $job_activitys = JobActivities::where('position_order', '>', $job_activity->position_order)->get();
        // // echo '<pre>'; print_r($job_activitys->toArray()); exit;
        // $i =  $job_activity->position_order;
        // foreach($job_activitys as $active)
        // {
        //     $act = JobActivities::find($active->id);
        //     $act->position_order = $i;
        //     $act->save();
        //     $i++;
        // }        
        $job_activity->delete();
       return redirect()->route('job_activities.index')->with('success','Activity deleted successfully');
    }

    public function getComponents($id)
    {
        // $components = ResourceComponents::where('country', $id)->get();
        $components = ResourceComponents::all();
        return response()->json($components);        
    }

    public function getCopyActivities($id)
    {
        $job_activity = JobActivities::find($id);
        $components = ResourceComponents::orderBy('component_id','asc')->get();
        $descriptions = ActivityDescription::orderBy('title','asc')->get();        
        $component_ids = explode(',',$job_activity->components);
        $countries = Countries::orderBy('id','desc')->get();
        $job_components = JobComponent::where('job_id', $job_activity->id)->get()->toArray();

        $job_component_data = array();
        $country_ids = array();
        $i = 0;
        foreach($job_components as $k => $job_component)
        {
            if(!in_array($job_component['country_id'], $country_ids))
            {
                $country_ids[] = $job_component['country_id'];
                $country = Countries::where('id', $job_component['country_id'])->first()->toArray();
                $job_component_data[$k]['country'] = $country;                                
                $job_component_data[$k]['detail'][] = $job_component;
                $i = $k;
            }
            else{
                $job_component_data[$i]['detail'][] = $job_component;
            }            
        }        
        return view('job_activities.copy',compact('job_activity','descriptions','components','component_ids', 'countries', 'job_component_data'));
    }

    public function saveCopyActivitiesData(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'category' => 'required',            
            'activity_code' => 'required',  
            'addmore'=>'required',
            'imperial_unit'=>'required',
            'conservation_factor'=>'required',
            'metric_unit'=>'required',
            'country' => 'required'     
        ]);
        $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
       $output = JobActivities::create([
            'description' => $request->description,
            'category' => $request->category,            
            'activity_code' => $request->activity_code,
            'imperial_unit'=>$request->imperial_unit,
            'conservation_factor'=>$request->conservation_factor,
            'metric_unit'=>$request->metric_unit,
           'country_id' => implode(',', $request->country),
           'position_order' => $position_order->position_order + 1
        ]);
        
        $input = array();        
        foreach($request->addmore as $k => $values){            
            foreach($values as $value)
            {
                $input[] = [
                    'component_id'=>$value['component_id'],
                    'quantity'=>$value['quantity'],
                    'job_id'=>$output->id,
                    'country_id'=>$k
                ];
            }
        }          
        JobComponent::where('job_id',$output->id)->delete();
       JobComponent::insert( $input);
        return redirect()->route('job_activities.index')->with('success','Copy Data Successfully.');
    }

    public function updateOrder(Request $request)
    {
        $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
        $positions = $request->position;
        $page = $request->page;
        if($page == 1)
        {
            $i = $position_order->position_order;
        }        
        else{
            $i = abs($position_order->position_order - (($page * 50) - 50));
        }        
        foreach($positions as $position)
        {
            $active = JobActivities::find($position);
            $active->position_order = $i;
            $active->save();
            $i--;
        }
        
        echo json_encode(['start' => true]);
    }
    public function updateOrderNext($page,Request $request)    
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        
        // print_r($ids);
        // $lists = JobActivities::orderBy('id','asc')->get();
        // foreach($lists as $key => $list){
        //     $list->position_order = $key + 1;
        //     $list->save();
        // }
        // exit;
        $ids = $request->input("ids");
        for($i = 0;$i < count($ids);$i++){
            JobActivities::where('id',$ids[$i])->decrement('position_order', 50);
            $activity = JobActivities::where('id',$ids[$i])->first();
            $position_order = $activity->position_order;

            JobActivities::where('position_order','>=',$position_order)
                         ->where('id',"!=",$activity->id)
                         ->increment('position_order',1);

            // JobActivities::where('position_order','>=',$position_order)
            //              ->where('id',"!=",$activity->id)
            //              ->update([
            //                 'position_order'=> DB::raw('position_order+1')
            //               ]);

            
            // $activities = JobActivities::where('position_order','>',$position_order)
            //                 ->where('id',"!=",$ids[$i])
            //                 ->get();
            // foreach($activities as $key => $act){
            //     $new_position = $position_order+$key;
            //     // echo $new_position."<br>";
            //     JobActivities::where('id',$act->id)->update(['position_order'=>$new_position]);
            // }
        }
       
        $response['status'] = true;
        \Session::flash('success','Activities moved to next');
        return response()->json($response);
    }

    public function updateOrderPrv($page,Request $request)    
    {
        // $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
        // $positions = $position_order->position_order;        

        // $prvosition = abs($positions - (($page * 50) - 50));        
        // $nextposition = $prvosition + 1;

        // $prvactive = JobActivities::where('position_order',$prvosition)->first();
        // $nextactive = JobActivities::where('position_order',$nextposition)->first();

        // $nextactive->position_order = $prvosition;
        // $nextactive->save();
        
        // $prvactive->position_order = $nextposition;
        // $prvactive->save();        

        // return redirect()->route('job_activities.index');

        $ids = $request->input("ids");
        
        for($i = 0;$i < count($ids);$i++){

            JobActivities::where('id',$ids[$i])->increment('position_order', 50);
            $activity = JobActivities::where('id',$ids[$i])->first();
            $position_order = $activity->position_order;
            JobActivities::where('position_order','<=',$position_order)
                         ->where('id',">",$activity->id)
                         ->where('id',"!=",$activity->id)
                         ->decrement('position_order',1);

            
            // $position_order = JobActivities::where('id',$ids[$i])
            //                             ->orderBy('position_order', 'desc')
            //                             ->first();        
            // $positions = $position_order->position_order;  
            // $nextposition = $positions + 51;   
            // JobActivities::where("id",$position_order->id)->update(['position_order'=>$nextposition]);
  
        }
        // $lists = JobActivities::select('id','activity_code','position_order')->orderBy('position_order','asc')->get();
        // foreach($lists as $key => $list){
        //       $new_position = ($key+1);
        //       JobActivities::where("id",$list->id)->update(['position_order'=>$new_position]);
        // }
        // $lists = JobActivities::orderBy('position_order','asc')->get();
        // foreach($lists as $key => $list){
        //     $list->position_order = $key + 1;
        //     $list->save();
        // }
        $response['status'] = true;
        \Session::flash('success','Activities moved previous');
        return response()->json($response);
    }
    public function updateOrderNext_old($page)    
    {
        $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
        $positions = $position_order->position_order;        
        $nextposition = abs($positions - ($page * 50));                
        $prvposition = $nextposition + 1;

        $nextactive = JobActivities::where('position_order',$nextposition)->first();
        $prvactive = JobActivities::where('position_order',$prvposition)->first();

        $nextactive->position_order = $prvposition;
        $nextactive->save();
        
        $prvactive->position_order = $nextposition;
        $prvactive->save();        

        return redirect()->route('job_activities.index');
    }

    public function updateOrderPrv_old($page)    
    {
        $position_order = JobActivities::orderBy('position_order', 'desc')->first();        
        $positions = $position_order->position_order;        

        $prvosition = abs($positions - (($page * 50) - 50));        
        $nextposition = $prvosition + 1;

        $prvactive = JobActivities::where('position_order',$prvosition)->first();
        $nextactive = JobActivities::where('position_order',$nextposition)->first();

        $nextactive->position_order = $prvosition;
        $nextactive->save();
        
        $prvactive->position_order = $nextposition;
        $prvactive->save();        

        return redirect()->route('job_activities.index');
    }

   public function updateActivityCode(Request $request){
        $request->validate([
            'activity_code' => 'required'          
        ],
        [
            'activity_code.required'=>"Select the Activity to update"
        ]
        );
        $activity_code = $request->input("activity_code");
        
        foreach($activity_code as $key => $value){
            JobActivities::where("id",$key)->update(['activity_code'=>$value['activity_code'],'description'=>$value['description']]);
        }
        return redirect()->back()->with('success','Activity Code Updated Successfully.');
    }
}
