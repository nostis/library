<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Librarian']);
        Role::create(['name' => 'Client']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@abc.com',
            'password' => '$2y$10$TISWoOA9o26nqInTAOIxzOHTLnYI72RnmWik82n8K98Yukq8lsFaq' //password
        ])->assignRole('Admin');


        User::create([
            'name' => 'Librarian',
            'email' => 'librarian@abc.com',
            'password' => '$2y$10$TISWoOA9o26nqInTAOIxzOHTLnYI72RnmWik82n8K98Yukq8lsFaq' //password
        ])->assignRole('Librarian');

        User::create([
            'name' => 'Client',
            'email' => 'client@abc.com',
            'password' => '$2y$10$TISWoOA9o26nqInTAOIxzOHTLnYI72RnmWik82n8K98Yukq8lsFaq' //password
        ])->assignRole('Client');
    }
}