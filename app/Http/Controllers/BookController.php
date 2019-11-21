<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\RentBookRequest;
use App\Http\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller {
    private $bookService;

    public function construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function rentBook(RentBookRequest $request) : JsonResponse {
        return $this->bookService->rentBook($request);
    }
}