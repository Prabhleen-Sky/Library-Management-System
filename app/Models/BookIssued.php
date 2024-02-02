<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookIssued extends  Eloquent
{
    protected $connection = "mongodb";
    protected $collection = "issuedBooks";
    protected $fillable = [
        "user_id", "book_id"
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', '_id');
    }
}
