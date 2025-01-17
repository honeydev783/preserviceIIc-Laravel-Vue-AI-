<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityDescription;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = ActivityDescription::orderBy('position_order','asc')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'                       
        ]);
        
        $position_order = ActivityDescription::orderBy('position_order', 'desc')->first();                
        $category =  new ActivityDescription();
        $category->title = $request->title;
        $category->position_order = $position_order->position_order + 1;
        $category->save();
             
        return redirect()->route('categories.index')->with('success','Category Successfully created.');
    }

    public function show(ActivityDescription $categories)
    {
        //
    }

    public function edit(ActivityDescription $category)
    {
 
        return view('categories.edit',compact('category'));
    }

    public function update(Request $request, ActivityDescription $category)
    {
        $request->validate([
            'title' => 'required',           
        ]);
        $category->update($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = ActivityDescription::find($id);
        $categories = ActivityDescription::where('position_order', '>', $category->position_order)->get();

        $i =  $category->position_order;
        foreach($categories as $cat)
        {
            $act = ActivityDescription::find($cat->id);
            $act->position_order = $i;
            $act->save();
            $i++;
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success','Category deleted successfully');
    }

    public function updateOrder(Request $request)
    {
        $position_order = ActivityDescription::orderBy('position_order', 'asc')->first();             
        $positions = $request->position;
        $page = $request->page;
        if($page == 1)
        {
            $i = $position_order->position_order;
        }        
        else{
            $i = abs($position_order->position_order + (($page * 15) - 15));
        }        
        foreach($positions as $position)
        {
            $category = ActivityDescription::find($position);
            $category->position_order = $i;
            $category->save();
            $i++;
        }
        
        echo json_encode(['status' => true]);
    }

    public function updateOrderNext($page)    
    {        
        $positions = 1;
        $nextposition = abs($positions + ($page * 15));                
        $prvposition = $nextposition - 1;

        $nextactive = ActivityDescription::where('position_order',$nextposition)->first();
        $prvactive = ActivityDescription::where('position_order',$prvposition)->first();

        $nextactive->position_order = $prvposition;
        $nextactive->save();
        
        $prvactive->position_order = $nextposition;
        $prvactive->save();        

        return redirect()->route('categories.index');
    }

    public function updateOrderPrv($page)    
    {        
        $positions = 1;
        $prvosition = abs((($page * 15) - 15));        
        $nextposition = $prvosition + 1;

        $prvactive = ActivityDescription::where('position_order',$prvosition)->first();
        $nextactive = ActivityDescription::where('position_order',$nextposition)->first();

        $nextactive->position_order = $prvosition;
        $nextactive->save();
        
        $prvactive->position_order = $nextposition;
        $prvactive->save();        

        return redirect()->route('categories.index');
    }
}
