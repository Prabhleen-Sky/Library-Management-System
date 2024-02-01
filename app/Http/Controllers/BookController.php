<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //
    public function index()
    {
        $books = Book::all();
        return view("book.index", ['books' => $books]);
    }

    public function addBook()
    {
        return view('book.addBookForm');
    }

    public function storeBook(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
                'author' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z\s]+$/'],
                'description' => ['required', 'string', 'regex:/^[^<>]*$/'],
                'total_inventory' => ['required', 'numeric', 'between:0,100'],
                'price' => ['required', 'numeric', 'between:0,2000'],
                'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ],
            [
                'name.regex' => 'Book name must contain only alphabets or spaces',
                'author.regex' => 'Book name must contain only alphabets or spaces',
                'description.regex' => 'Description must not contain any html attribute',
                'total_inventory.between' => 'Price must be between :min and :max',
                'price.between' => 'Price must be between :min and :max',
                'photo.image' => 'photo must be an image',
                'photo.mimes' => 'Photo must have one of the following extensions: jpeg, png, jpg, gif',
                'photo.max' => 'Photo must not exceed :max kilobytes',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request>file('photo')->store('images', 'public');
        }

        $book = Book::create([
            'name' => $data['name'],
            'author' => $data['author'],
            'description' => $data['description'],
            'total_inventory' => $data['total_inventory'],
            'price' => $data['price'],
            'photo' => $photoPath,
            'status' => 'available',
            'issued_copies' => '0'
        ]);

        return redirect('manage-books')->with('success','Book added successfully');
    }

    public function editBook($id)
    {
        $book = Book::find($id);
        return view('book.editBookForm', ['books' => $book]);
    }

    public function deleteBook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('manage-books')->with('error', 'Book not found');
        }

        $book->delete();

        return redirect('manage.books')->with('success', 'Book deleted successfully');
    }
}
