<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    //

    public function settings(){
        $settings = Settings::first();
        return view("settings",compact("settings"));
    }

    public function settingUpdate(Request $request){
        $setting = Settings::first();
 
        $setting->estimate_expiry_time = $request->input("estimate_expiry_time");
        $setting->save();

        return redirect()->back()->with('success','Setting updated successfully');
    }
}
