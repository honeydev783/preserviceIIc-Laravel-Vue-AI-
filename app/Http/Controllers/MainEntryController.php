<?php

namespace App\Http\Controllers;

use App\Models\MainEntry;
use App\Models\EntryImages;
use App\Models\RockValue;
use Illuminate\Http\Request;
use App\Models\Menus;
use App\Models\Countries;
use Route;
use Session;
use File;
use App\Models\SoilConditions;

class MainEntryController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $route_name =  request()->segment(2);
        // echo $route_name; exit;
        $this->setSession($route_name);         
        $entries = MainEntry::where('category',Session::get('category'))->orderBy('id','desc')->paginate(30);                 
        return view('main_entry.index',compact('entries'));

    }

    public function setSession($route_name){              
        // $category = '';       
        // $title = '';
        // switch($route_name){
        //     case 'low_concrete':
        //         $category = 1;
        //         $title = 'Low End Concrete Dwelling';              
        //         break;
        //     case 'high_concrete':
        //         $category = 2;
        //         $title = 'High End Concrete Dwelling';
               
        //         break;
        //     case 'low_commercial':
        //         $category = 3;
        //         $title = 'Low End Commercial Offices';
                
        //         break;
        //     case 'high_commercial':
        //         $category = 4;
        //         $title = 'High End Commercial Offices';               
        //         break;
        //     case 'ware_house':
        //         $category = 5;
        //         $title = 'Ware House';               
        //         break;
        // }
        // Session::put('title',$title);
        // Session::put('category',$category);    
        // Session::put('index_route_name',$route_name.'.index');    
        // Session::put('create_route_name',$route_name.'.create');    
        // Session::put('edit_route_name',$route_name.'.edit');
        // Session::put('store_route_name',$route_name.'.store');
        // Session::put('update_route_name',$route_name.'.update');
        // Session::put('destroy_route_name',$route_name.'.destroy');
        $menu = Menus::where('url',$route_name)->first();        
        Session::put('title',$menu->menu_name);
        Session::put('category',$menu->id);    
        Session::put('index_route_name',$route_name.'.index');    
        Session::put('create_route_name',$route_name.'.create');    
        Session::put('edit_route_name',$route_name.'.edit');
        Session::put('store_route_name',$route_name.'.store');
        Session::put('update_route_name',$route_name.'.update');
        Session::put('destroy_route_name',$route_name.'.destroy');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $countries = Countries::orderBy('id','desc')->get();
        $route_name =  request()->segment(2);        
        $this->setSession($route_name);      
        return view('main_entry.create', compact('countries'));
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
            'cost_m2' => 'required',
            'unit_m2' => 'required',
            'cost_sf' => 'required',
            'unit_sf' => 'required',
            'element_code' => 'required',
            'country' => 'required',
            
        ]);            
        MainEntry::create([
            'description'=>$request->description,
            'cost_m2'=>$request->cost_m2,
            'unit_m2'=>$request->unit_m2,
            'cost_sf'=>$request->cost_sf,
            'unit_sf'=>$request->unit_sf,
            'element_code'=>$request->element_code,
            'country_id' => $request->country,
            'category'=>Session::get('category'),
        ]);
     
        return redirect()->route(Session::get('index_route_name'))
                        ->with('success','Successfully created.');
    }

    /**
     * Display the specified resource.
        *
     * @param  \App\Models\MainEntry  $mainEntry
     * @return \Illuminate\Http\Response
     */
    public function show(MainEntry $mainEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MainEntry  $mainEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $route_name =  request()->segment(2);        
        $this->setSession($route_name);  
        $entry = MainEntry::find($id);      
        $countries = Countries::orderBy('id','desc')->get();
        return view('main_entry.edit',compact('entry', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainEntry  $mainEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'description' => 'required',
            'cost_m2' => 'required',
            'unit_m2' => 'required',
            'cost_sf' => 'required',
            'unit_sf' => 'required',
            'element_code' => 'required',
            'country' => 'required',
        ]);
        $entry = MainEntry::find($id);     
        $entry->description = $request->description;
        $entry->cost_m2 = $request->cost_m2;
        $entry->unit_m2 = $request->unit_m2;
        $entry->cost_sf = $request->cost_sf;
        $entry->unit_sf = $request->unit_sf;
        $entry->element_code = $request->element_code;
        $entry->is_story = isset($request->is_story) ? 1:0;
        $entry->country_id = implode(',',$request->country);
        $entry->soil_condition = $request->soil_condition;
        $entry->save();
        return redirect()->route(Session::get('index_route_name'))
                        ->with('success','Updated successfully');
    }

    public function viewUploadImage(){
       $category = Session::get('category');
        return view('main_entry.upload-image',compact('category'));
    }

     
    public function uploadImage(Request $request){
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
                    
        $imageName = time().'.'.$request->file->extension();       
        $request->file->move(public_path('entry_images'), $imageName);
        $entry = EntryImages::where('category',$request->category)->first();
        if(!empty($entry)){
            if($entry->image_name == 'default.png'){

            }
            else{
                $image_path = public_path('entry_images/').$entry->image_name;  // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $entry->image_name = $imageName;
            $entry->save();
        }
                 
        if($request->type == 2){
            $image_src = url('/entry_images').'/'.$entry->image_name;
            return response()->json(['image_src'=>$image_src],200);
        }
        else{
            return back()
            ->with('success', 'File uploaded successfully');
        }
        

    }

    public function viewRock(Request $request){
        $rock = RockValue::where('category',Session::get('category'))->first();
        return view('main_entry.update-rock',compact('rock'));
    }

    public function updateRock(Request $request,RockValue $rock){
        $request->validate([
            'rock_value' => 'required',
            'category' => 'required',             
        ]);      
        $rock->update($request->all());
        return back()
            ->with('success', 'Rock value updated successfully');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainEntry  $mainEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = MainEntry::find($id);     
        $entry->delete();    
        return redirect()->route(Session::get('index_route_name'))
                        ->with('success','Successfully deleted');
    }

    public function saveMenu(Request $request)
    {
        $menu = new Menus;
        $menu->menu_name = $request->menu;
        $menu->url = $request->url;
        $menu->save();

        $rock = new RockValue;
        $rock->category = $menu->id;
        $rock->rock_value = 0;
        $rock->save();

        $soil_conditions = new SoilConditions;
        $soil_conditions->category = $menu->id;
        $soil_conditions->sandy_soil = 0;
        $soil_conditions->loam_soil = 0;
        $soil_conditions->soft_clay_soil = 0;
        $soil_conditions->stiff_clay_soil = 0;
        $soil_conditions->hard_soil = 0;
        $soil_conditions->soft_soil = 0;
        $soil_conditions->ordinary_soil = 0;
        $soil_conditions->save();
        return redirect('dashboard')->with('success', 'Menu Add successfully');
    }

    public function removeMenu($id)
    {
        Menus::find($id)->delete(); 
        RockValue::where('category', $id)->delete(); 
        SoilConditions::where('category', $id)->delete();      
        return redirect('dashboard')->with('success', 'Menu Remove successfully');
    }

    public function viewSoilConditions(Request $request){
        $soil_condition = SoilConditions::where('category',Session::get('category'))->first();
        return view('main_entry.update-soil-conditions',compact('soil_condition'));
    }

    public function updateSoilConditions(Request $request,$id){
        $request->validate([
            'sandy_soil' => 'required',
            'loam_soil' => 'required',
            'soft_clay_soil' => 'required',
            'stiff_clay_soil' => 'required',
            'hard_soil' => 'required',
            'soft_soil' => 'required',
            'category' => 'required',      
            'ordinary_soil' => 'required',       
        ]); 
        $soil_condition = SoilConditions::find($id);    
        $soil_condition->sandy_soil = $request->sandy_soil;
        $soil_condition->loam_soil = $request->loam_soil;
        $soil_condition->soft_clay_soil = $request->soft_clay_soil;
        $soil_condition->stiff_clay_soil = $request->stiff_clay_soil;
        $soil_condition->hard_soil = $request->hard_soil;
        $soil_condition->soft_soil = $request->soft_soil;
        $soil_condition->ordinary_soil = $request->ordinary_soil;
        $soil_condition->save();
        return back()
            ->with('success', 'Soil Condition value updated successfully');        
    }

    public function getSoilCondition($soil_condition)
    {
        $category = Session::get('category');
        $soil_condition_data = SoilConditions::where('category', $category)->first();
        $soil_condition_value = 0;
        if($soil_condition == 1)
        {
            $soil_condition_value = $soil_condition_data->ordinary_soil;
        }
        else if($soil_condition == 2)
        {
            $soil_condition_value = $soil_condition_data->sandy_soil;
        }
        else if($soil_condition == 3)
        {
            $soil_condition_value = $soil_condition_data->loam_soil;
        }
        else if($soil_condition == 4)
        {
            $soil_condition_value = $soil_condition_data->soft_clay_soil;
        }
        else if($soil_condition == 5)
        {
            $soil_condition_value = $soil_condition_data->stiff_clay_soil;
        }
        else if($soil_condition == 6)
        {
            $soil_condition_value = $soil_condition_data->hard_soil;
        }
        else if($soil_condition == 7)
        {
            $soil_condition_value = $soil_condition_data->soft_soil;
        }
        return response()->json($soil_condition_value);    
    }
}
