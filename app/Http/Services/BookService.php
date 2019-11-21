<?php

namespace App\Http\Services;

use App\Http\Requests\Book\RentBookRequest;
use App\Models\BookUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BookService {
    public function rentBook(RentBookRequest $request) : JsonResponse {
        $data = $request->validated();

        BookUser::create([
            'book_id' => $data['book_id'],
            'user_id' => Auth::user()->id,
            'is_returned' => false
        ]);

        return response()->json(['message' => 'Successfully rented book'], 200);
    }
}