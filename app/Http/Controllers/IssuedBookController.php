<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookIssued;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IssuedBookController extends Controller
{
    //
    public function index(){
        $issuedBooks = BookIssued::with(['book', 'user'])->get();
        return view("issueBook.index", compact('issuedBooks'));
    }

    public function issueBook(){
        return view("issueBook.issueBookForm");
    }

    public function storeIssuedBook(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'book_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $issueBook = BookIssued::create($data);

        return redirect('manage-issued-book')->with('success','Book Issued Successfully');

    }
}
