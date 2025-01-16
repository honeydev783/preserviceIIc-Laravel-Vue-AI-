<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\ApproxEstimateForm;
use App\Models\DetailEstimateForm;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (\Auth::attempt($credentials)) {
            $expiry_time = date("Y-m-d H:i:s",strtotime("+6 hours"));
            
            $current_time = date("Y-m-d H:i:s");
            $detail_forms = DetailEstimateForm::where("expiry_time","<=",$expiry_time)
                                            ->where('user_id', \Auth::user()->id)
                                            ->count();

            $approx_forms = ApproxEstimateForm::where("expiry_time","<=",$expiry_time)
                                            ->where('user_id', \Auth::user()->id)
                                            ->count();

            if($detail_forms > 0){
                $detail_forms = DetailEstimateForm::where("expiry_time","<=",$expiry_time)
                                              ->where('user_id', \Auth::user()->id)
                                              ->pluck('id')
                                              ->toArray();
                \Session::put("exp_detail_forms",implode(",",$detail_forms));
            }
            if($approx_forms > 0){
                $approx_forms = ApproxEstimateForm::where("expiry_time","<=",$expiry_time)
                                            ->where('user_id', \Auth::user()->id)
                                            ->pluck('id')
                                            ->toArray();
                \Session::put("exp_approx_forms",implode(",",$approx_forms));
            }
            return redirect()->intended('dashboard');
        }
  
        return redirect("login")->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
