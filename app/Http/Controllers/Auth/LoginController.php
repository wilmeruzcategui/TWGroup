<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        
        $messages = [
            'email.required' => 'The email is required.',
            'email.email' => 'The email needs to have a valid format.',
            'password.required' => 'The password is required.',
        ];
        
        
        $this->validate($request, $rules, $messages);
     
        $credentials = $request->only('email', 'password');
        if (\Auth::attempt($credentials)) {
  
            return redirect()->route('home');
        }
        //return redirect("login")->withErrors(['msg', 'Invalid credentials or unregistered user']);
        return redirect("login")->with('error', 'Invalid credentials or unregistered user');   
       
    }
}
