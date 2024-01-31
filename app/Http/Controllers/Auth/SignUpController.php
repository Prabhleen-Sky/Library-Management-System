<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class SignUpController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'fname' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z]+$/'],
            'lname' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z]+$/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!(filter_var($value, FILTER_VALIDATE_EMAIL) && Str::endsWith($value, '.com'))) {
                        $fail('The ' . $attribute . ' must be a valid email address ending with ".com".');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
        ],[
            'fname.regex'=> 'first name must contain only alphabets and that too without spaces',
            'lname.regex'=> 'last name must contain only alphabets and that too without spaces',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'status' => 'active',
            'user_role' => 'student'
        ]);

        return redirect()->route('login')->with('success', 'Registration successful, You can login');
    }

}
