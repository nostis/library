<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author_name', 'author_surname', 'pages', 'country', 'isbn', 'is_booked'];
    
}
