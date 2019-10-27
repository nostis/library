<?php

use Illuminate\Database\Seeder;

class BooksSeederSQL extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopsInsert = file_get_contents($this->getDirectoryPath() . '/seeds/books.sql');

        DB::connection()->getPdo()->exec($shopsInsert);

        DB::table('books')->update([
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function getDirectoryPath() {
        return database_path();
    }
}
