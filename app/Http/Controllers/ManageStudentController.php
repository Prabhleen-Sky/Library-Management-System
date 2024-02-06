<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\BookIssued;
use Illuminate\Validation\Rule;

class ManageStudentController extends Controller
{
    //
    public function index()
    {
        try {

            $students = DB::collection('users')->where('user_role', 'student')->get();
            // Log::info($students);
            $books = Book::all();
            return view("manageStudent.index", ['students' => $students, 'books' => $books]);
        } catch (\Exception $e) {
            report($e);
        }
    }

    public function addStudent()
    {
        return view("manageStudent.addStudentForm");
    }

    public function storeStudent(Request $request)
    {
        try {
            $data = $request->all();
        } catch (\Exception $e) {
            report($e);
        }

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

        try {
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
        } catch (\Exception $e) {
            report($e);
            return redirect('manage-books')->with('error', 'Failed to add student');
        }

    }

    public function editStudent($id)
    {
        try {
            $student = User::findOrFail($id);
            return view("manageStudent.editStudentForm", ["student" => $student]);
        } catch (\Exception $e) {
            report($e);
            return redirect('manage-books')->with('error', 'Failed to edit student : ' . $e->getMessage());
        }
    }

    public function storeUpdatedStudent(Request $request, $id)
    {
        try {
            $data = $request->all();
        } catch (\Exception $e) {
            report($e);
        }

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
                    'unique:users,email,' . $id . ',_id', // Ignore current user with this ID
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

        try {

            $student = User::findOrFail($id);
            // \Log::info($student);

            if (!$student) {
                return redirect()->back()->with('error', 'User not found.');
            }
           
            try{
                $student->update($data);
                return redirect('manage-students')->with('success', 'User updated successfully');
            }catch (\Exception $e) {
                report($e);
                return redirect('manage-students')->with('Failed to update User');
            }
        } catch (\Exception $e) {
            report($e);
        }

    }

    public function deleteStudent($id)
    {
        try{

            $user = User::find($id);
            
            if (!$user) {
                return redirect("manage-students")->with("error", "User not found");
            }
            
            $user->delete();
            
            return redirect("manage-students")->with("success", "User deleted successfully");
        }catch(\Exception $e) {
           report($e);
           return redirect("manage-students")->with("error", "Failed to delete User");
        }
    }

    public function issueBook(Request $request)
    {
        $studentId = $request->input('studentId');
        \Log::info(''. $studentId);
        $bookId = $request->input('bookId');
        
        try {
            $issueBook = BookIssued::create([
                'user_id' => $studentId,
                'book_id' => $bookId,
            ]);
        }catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while creating the BookIssued record.');
        }

        return response()->json(['success' => true]);
    }
}
