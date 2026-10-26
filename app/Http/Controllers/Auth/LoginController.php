<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $rules =[
            'email' =>  'required|email|exists:users',
            'password' => 'required',
        ];
        $messages = ([
            'email.required' => 'يرجي ادخال البريد الالكتروني ',
            'email.email' => 'يرجي ادخال البريد الالكتروني صحيح',
            'password.required' => 'يرجي ادخال كلمه المرور ',
            'email.exists' => 'البريد الالكتروني غير موجود بقاعده البيانات',

        ]);
        $this->validate($request, $rules, $messages);
        $input = $request->all();
        $user = auth()->user();

        if (Auth::guard('web')->attempt(['email' => request('email'),
            'password' => request('password'),'enabled' => 1]))
        {
            return redirect()->route('home');
        }


        $user = User::where('email', $request->email)->first();

        if($user->enabled == 0)
        {
            session()->flash('error', __('هذا المستخدم غير مفعل'));
            return redirect()->route('login');
        }


        if (!Hash::check($request->password, $user->password) ) {
            session()->flash('error', __('كلمه المرور غير صحيحه'));

            return redirect()->route('login');

        }
        return redirect()->route('login');


    }
}
