<?php

namespace App\Http\Controllers\Panels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index(){
        $student = auth()->user();
        return view("student", compact('student'));
    }
}
