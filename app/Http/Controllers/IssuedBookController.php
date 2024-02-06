<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookIssued;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IssuedBookController extends Controller
{
    //
    public function index()
    {
        try {
            $issuedBooks = BookIssued::with(['book', 'user'])->get();
            return view("issueBook.index", compact('issuedBooks'));
        } catch (\Exception $e) {
            return report($e);
        }
        // $issuedBooks = BookIssued::with(['book', 'user'])->get();
        // return view("issueBook.index", compact('issuedBooks'));
    }

    public function issueBook()
    {
        return view("issueBook.issueBookForm");
    }

    public function storeIssuedBook(Request $request)
    {
        try {
            $data = $request->all();
        } catch (\Exception $e) {
            report($e);
        }

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'book_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $issueBook = BookIssued::create($data);
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'An error occurred while creating the BookIssued record.');
        }

        return redirect('manage-issued-book')->with('success', 'Book Issued Successfully');

    }

    public function checkIssuedBook(Request $request)
    {
        $studentId = $request->input('studentId');
        $bookId = $request->input('bookId');

        $checkIssuedBook = BookIssued::where('user_id', $studentId)
            ->where('book_id', $bookId)
            ->first();

        if ($checkIssuedBook) {
            return response()->json(['alreadyIssued' => true]);
        } else {
            return response()->json(['alreadyIssued' => false]);
        }
    }

    public function deleteIssuedBook(Request $request)
    {
        $studentId = $request->input('studentId');
        $bookId = $request->input('bookId');

        try {
            $deleted = BookIssued::where('user_id', $studentId)
                ->where('book_id', $bookId)
                ->delete();
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => 'An error occurred while deleting the BookIssued record.'], 500);
        }

        return response()->json(['success' => true]);
    }
}
