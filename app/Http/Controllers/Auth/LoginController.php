<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (!(filter_var($value, FILTER_VALIDATE_EMAIL) && Str::endsWith($value, '.com'))) {
                        $fail('The ' . $attribute . ' must be a valid email address ending with ".com".');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $data['email'])->first();

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Log::info($user);

            if ($user->user_role === 'student') {
                return redirect('studentpanel');
            }

            return redirect('adminpanel');
        }else{
            $request->session()->flash('error', 'Invalid Email or Password! Try Again!');
            return redirect()->back();
        }

    }


}
