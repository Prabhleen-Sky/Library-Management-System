<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ManageStudentController extends Controller
{
    //
    public function index()
    {
        $students = DB::collection('users')->where('user_role', 'student')->get();
        // Log::info($students);
        return view("manageStudent.index", ['students' => $students]);
    }

    public function addStudent()
    {
        return view("manageStudent.addStudentForm");
    }

    public function storeStudent(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
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
                'password' => ['required', 'string', 'min:8'],
                'phone' => ['required', 'string', 'min:10', 'max:15'],
            ],
            [
                'fname.regex' => 'first name must contain only alphabets and that too without spaces',
                'lname.regex' => 'last name must contain only alphabets and that too without spaces',
            ]
        );

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

        return redirect('manage-students')->with('success', 'User added successfully');

    }

    public function editStudent($id)
    {
        $student = User::findOrFail($id);
        return view("manageStudent.editStudentForm", ["student" => $student]);
    }

    public function storeUpdatedStudent(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'fname' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z]+$/'],
                'lname' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z]+$/'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:50',
                    'unique:users,email,'.$id.',_id', // Ignore current user with this ID
                    function ($attribute, $value, $fail) {
                        if (!(filter_var($value, FILTER_VALIDATE_EMAIL) && Str::endsWith($value, '.com'))) {
                            $fail('The ' . $attribute . ' must be a valid email address ending with ".com".');
                        }
                    }
                ],
                'phone' => ['required', 'string', 'min:10', 'max:15'],
            ],
            [
                'fname.regex' => 'first name must contain only alphabets and that too without spaces',
                'lname.regex' => 'last name must contain only alphabets and that too without spaces',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $student = User::findOrFail($id);
        // \Log::info($student);

        if(!$student){
            return redirect()->back()->with('error', 'User not found.');
        }

        $student->update($data);

        return redirect('manage-students')->with('success','User updated successfully');

    }

    public function deleteStudent($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect("manage-students")->with("error", "User not found");
        }

        $user->delete();

        return redirect("manage-students")->with("success", "User deleted successfully");
    }

    public function issueBook()
    {
        return "issue book";
    }
}
