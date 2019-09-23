<?php

use Illuminate\Database\Seeder;

class ShopsSeederSQL extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopsInsert = file_get_contents($this->getDirectoryPath() . 'books.sql');

        DB::connection()->getPdo()->exec($shopsInsert);
    }

    private function getDirectoryPath() {
        return $_ENV['APP_PATH'] . 'database/seeds/';
    }
}
