<?php

namespace App\Http\Controllers;

use App\Models\ResourceComponents;
use App\Models\Countries;
use App\Models\ProcessStatus;
use Illuminate\Http\Request;
use App\Jobs\UpdateResourceComponentJob;
class ResourceComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $components = ResourceComponents::groupBy('component_id')->orderBy('component_id', 'asc')->orderBy('id', 'desc')->paginate(50);
        $enabled = ProcessStatus::where('id', 1)->first()->is_running;
        return view('components.master_index',compact('components', 'enabled'));
    }

    public function dispatchJob() {
        $components = ResourceComponents::groupBy('component_id')->orderBy('component_id', 'asc')->orderBy('id', 'desc')->paginate(50);
        dispatch(new UpdateResourceComponentJob());
        ProcessStatus::updateOrCreate(['id' => 1], ['is_running' => true]);
        $enabled = ProcessStatus::where('id', 1)->first()->is_running;
        return view('components.master_index',compact('components','enabled'));

    }

    public function stopJob() {
        $components = ResourceComponents::groupBy('component_id')->orderBy('component_id', 'asc')->orderBy('id', 'desc')->paginate(50);
        ProcessStatus::where('id', 1)->update(['is_running' => false]);
        $enabled = ProcessStatus::where('id', 1)->first()->is_running;
        return view('components.master_index',compact('components','enabled'));
    }

    public function global()
    {
        $countries = Countries::orderBy('id','desc')->get();
        return view('components.global', compact('countries'));
    }

    public function globalUpdate(Request $request)
    {
        $components = ResourceComponents::groupBy('component_id')->orderBy('component_id', 'asc')->orderBy('id', 'desc')->get();
        foreach ($components as $component) {
            foreach($request->country as $k => $country)
            {
                ResourceComponents::updateOrCreate([
                    'component_id' => $component->component_id,
                    'category' => $request->category,
                    'country' => $country,
                ], [
                    'rate' => $request->cal_rate[$country],
                    'orignal_rate' => $request->rate[$country],
                ]);
            }
        }
        return redirect()->route('resource_components.index')
            ->with('success', 'Successfully updated globally.');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::orderBy('id','desc')->get();
        return view('components.create', compact('countries'));
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
            'component_id' => 'required',
            'resource_type' => 'required',
            'category'=>'required|in:Preliminries,Labour,Equipment,Material',            
            'unit' => 'required',           
            'rate' => 'required',   
            'country' => 'required',        
            // 'quantity' => 'required',           
        ]);
        // echo '<pre>'; print_r($request->all()); exit;
        foreach($request->country as $k => $country)
        {
            // $rate = $request->rate;
            // if($request->category == 'Material')
            // {
            //     $countries = Countries::where('id', $country)->first();
            //     $rate = $request->rate * $countries->material_rate;
            // }
            $data = array(
                'component_id' => $request->component_id,
                'resource_type' => $request->resource_type,
                'unit' => $request->unit,
                'category' => $request->category,
                'rate' => $request->cal_rate[$country],
                'country' => $country,
                'orignal_rate' => $request->rate[$country],
            );            
            ResourceComponents::create($data);
        }
        if(isset($request->previous_url) && !empty($request->previous_url))
        {
            return redirect($request->previous_url)->with('success','Successfully created.');
        }
        else{
            return redirect()->route('resource_components.index')
            ->with('success', 'Successfully created.');    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResourceComponents  $resource_component
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceComponents $resource_component)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResourceComponents  $resource_component
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceComponents $resource_component)
    {
        $countries = Countries::orderBy('id','desc')->get();

        $country_lists = ResourceComponents::where('component_id', $resource_component->component_id)->get();
        $country_ids = array();
        foreach($country_lists as $country)
        {
            $country_ids[] = $country['country'];
        }
        // echo '<pre>'; print_r($country_lists); exit;
        return view('components.edit',compact('resource_component', 'countries', 'country_ids', 'country_lists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResourceComponents  $resource_component
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceComponents $resource_component)
    {
        $request->validate([
            'component_id' => 'required',
            'resource_type' => 'required',  
            'category'=>'required|in:Preliminries,Labour,Equipment,Material',           
            'unit' => 'required',           
            'rate' => 'required',
            'country' => 'required',           
            // 'quantity' => 'required',           
        ]);

        // echo '<pre>'; print_r($resource_component); exit;

        $country_lists = ResourceComponents::where('component_id', $resource_component->component_id)->get();
        $country_ids = array();
        foreach($country_lists as $country)
        {
            $country_ids[] = $country['country'];
        }
        // echo '<pre>'; print_r($request->cal_rate);
        // echo '<pre>'; print_r($request->country);
        $remove = array_diff($country_ids, $request->country);
        $new = array_diff($request->country, $country_ids);
        // echo '<pre>'; print_r($remove);
        // echo '<pre>'; print_r($new); exit;
        // exit;
        foreach($request->country as $k => $country)
        {
            if(!in_array($country, $new))
            {
                $data = ResourceComponents::where('component_id', $resource_component->component_id)->where('country', $country)->first();
                $data['component_id']  = $request->component_id;
                $data['resource_type']  = $request->resource_type;
                $data['unit']  = $request->unit;
                $data['category']  = $request->category;
                $data['rate']  = $request->cal_rate[$country];
                $data['country']  = $country;
                $data['orignal_rate'] = $request->rate[$country];
                $data->save();                
            }
            else{
                
                $data = new ResourceComponents();
                $data['component_id']  = $request->component_id;
                $data['resource_type']  = $request->resource_type;
                $data['unit']  = $request->unit;
                $data['category']  = $request->category;
                $data['rate']  = $request->cal_rate[$country];
                $data['country']  = $country;
                $data['orignal_rate'] = $request->rate[$country];
                $data->save(); 
            }
        }      

        foreach($new as $country)
        {
            
        }
        
        foreach($remove as $country)
        {
            $component = ResourceComponents::where('component_id', $resource_component->component_id)->where('country', $country)->first();
            $component->delete();
        }

        if(isset($request->previous_url) && !empty($request->previous_url))
        {
            return redirect($request->previous_url)->with('success','Component updated successfully');
        }
        else{
            return redirect()->route('resource_components.index')
            ->with('success', 'Component updated successfully');
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResourceComponents  $resource_component
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource_component = ResourceComponents::find($id);
        $resource_component->delete();
        return redirect()->back()->with('success','Component deleted successfully');
    }

    public function saveCopyComponentData(Request $request)
    {        
        $request->validate([
            'component_id' => 'required',
            'resource_type' => 'required',
            'category'=>'required|in:Preliminries,Labour,Equipment,Material',            
            'unit' => 'required',           
            'rate' => 'required',   
            'country' => 'required',        
            // 'quantity' => 'required',           
        ]);

        $rate = $request->rate;
        if($request->category == 'Material')
        {
            $countries = Countries::where('id', $request->country)->first();
            $rate = $request->rate * $countries->material_rate;
        }
        $data = array(
            'component_id' => $request->component_id,
            'resource_type' => $request->resource_type,
            'unit' => $request->unit,
            'category' => $request->category,
            'rate' => $rate,
            'country' => $request->country,
            'orignal_rate' => $request->rate
        );


        ResourceComponents::create($data);
     
        if(isset($request->previous_url) && !empty($request->previous_url))
        {
            return redirect($request->previous_url)->with('success','Copy Data Successfully.');
        }
        else{
            return redirect()->route('resource_components.index')->with('success','Copy Data Successfully.');
        }        
    }

    public function getCopyComponent($id)
    {
        $countries = Countries::orderBy('id','desc')->get();
        $resource_component = ResourceComponents::find($id);
        return view('components.copy',compact('resource_component', 'countries'));
    }    
    public function updateComponentIds(Request $request){
        $request->validate([
            'component_id' => 'required'          
        ],
        [
            'component_id.required'=>"Select the component to update"
        ]
        );
        $component_ids = $request->input("component_id");
        
        foreach($component_ids as $key => $value){
            ResourceComponents::where("id",$key)->update(['component_id'=>$value['component_id'],'resource_type'=>$value['resource_type']]);
        }
        return redirect()->back()->with('success','Component Ids Updated Successfully.');
    }

    public function getCountryRecordes($id)
    {
        $id = base64_decode($id);
        // echo $id; exit;
        $components = ResourceComponents::where('country', $id)->orderBy('component_id', 'asc')->orderBy('id', 'desc')->paginate(50);
        return view('components.index',compact('components'));
    }
    
}
