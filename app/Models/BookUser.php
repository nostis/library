<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\User;
use App\Models\Book;

class BookUser extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'is_returned'
    ];

    public function user() : Relation {
        return $this->belongsTo(User::class);
    }

    public function book() : Relation {
        return $this->belongsTo(Book::class);
    }

    protected $casts = [
        'is_returned' => 'boolean'
    ];
}
