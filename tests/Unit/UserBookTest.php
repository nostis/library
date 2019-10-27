<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class UserBookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        Artisan::call('config:cache');
    }

    /** @test */
    public function whenUserBookingBook_thenUserAndBookCanGetHistory() {
        $userId = User::create([
            'name' => 'user',
            'email' => 'abc@abc.com',
            'password' => 'password'
        ])->id;

        $bookId = Book::create([
            'title' => 'a',
            'author_name' => 'a',
            'author_surname' => 'a',
            'pages' => 1,
            'country' => 'a',
            'isbn' => 'a',
            'is_booked' => 0
        ])->id;

        DB::table('book_user')->insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'is_returned' => 0
        ]);

        $user = User::whereId($userId)->first();
        $book = Book::whereId($bookId)->first();
        
        $this->assertTrue($user->currentlyBooked->first()->is($book));
    }
}
