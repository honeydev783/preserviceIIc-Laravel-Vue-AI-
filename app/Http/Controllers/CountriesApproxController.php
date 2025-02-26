<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;

class CountriesApproxController extends Controller
{
    public function index()
    {
        $route_name = request()->segment(2);
        $countries = Countries::orderBy('id','desc')->paginate(30);
        return view('countries.approx_estimate.index', compact('countries'));
    }

    public function create()
    {
        return view('countries.approx_estimate.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required',
            'labour_rate' => 'required'
        ]);

        $country = new Countries();
        $country->country_name = $request->country_name;
        $country->labour_rate = $request->labour_rate;
        $country->save();
     
        return redirect()->route('approx_estimate.index')->with('success','Successfully created.');
    }

    public function show(Countries $countries)
    {
        //
    }

    public function edit(int $id)
    {
        $country = Countries::find($id);
        return view('countries.approx_estimate.edit', compact('country'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'country_name' => 'required',
            'labour_rate' => 'required',
        ]);
        $country = Countries::find($id);
        $country->country_name = $request->country_name;
        $country->labour_rate = $request->labour_rate;
        $country->save();
        return redirect()->route('approx_estimate.index')
            ->with('success', 'Country updated successfully');
    }

    public function destroy(int $id)
    {
        $country = Countries::find($id);
        $country->delete();
        return redirect()->route('approx_estimate.index')->with('success', 'Country deleted successfully');
    }

     public function countryDetails($id)
    {  
        $country = Countries::find($id);
        return response()->json(['country'=>$country],200);
    }
}
