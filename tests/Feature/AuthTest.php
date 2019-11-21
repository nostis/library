<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AuthTest extends TestCase
{ 
    use RefreshDatabase;

    private $client;
    private $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->headers = ['Accept' => 'application/json', 'Content-Type' => 'application/json'];
        $this->client = new Client(['base_uri' => 'http://library-back.local.gd']);

        Artisan::call('config:cache');
        Artisan::call('passport:install');

        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Librarian']);
        Role::firstOrCreate(['name' => 'Client']); //to fix
    }

    /** @test */
    public function whenLoginUser_thenReturnToken() {
        User::create([
            'name' => 'user2',
            'email' => 'email2@email.com',
            'password' => '$2y$10$JjZ3BSpJfpJxfmDPruW5Q.Yq8ZanY4AXPoM4tWRWb5RUKRoAT362S' // 'password'
        ]);

        $response = $this->client->request('POST', '/api/auth/login', [
            'headers' => $this->headers,
            'json' => [
                'email' => 'email2@email.com',
                'password' => 'password',
            ]
        ]);

        $this->assertStringContainsString('token', $response->getBody()->getContents());
    }

    /** @test */
    public function whenRegisterAdmin_thenRegisterAndAssignRole() {
        User::create([
            'name' => 'Admin',
            'email' => 'email@test.abc',
            'password' => '$2y$10$TISWoOA9o26nqInTAOIxzOHTLnYI72RnmWik82n8K98Yukq8lsFaq' //password
        ])->assignRole('Admin');

        $token = $this->client->request('POST', '/api/auth/login', [
            'headers' => $this->headers,
            'json' => [
                'email' => 'email@test.abc',
                'password' => 'password'
            ]
        ])->getBody();

        $token = json_decode($token)->token;

        $this->headers['Authorization'] = 'Bearer ' . $token;
        
        $response = $this->client->request('POST', '/api/auth/admins', [
            'headers' => $this->headers,
            'json' => [
                'name' => 'user',
                'email' => 'email@email.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        ]);

        $response = json_decode($response->getBody());

        $this->assertStringContainsString('ey', $response->token);
        $this->assertStringContainsString('Admin', $response->user->roles[0]->name);
    }

    /** @test */
    public function whenRegisterLibrarian_thenRegisterAndAssignRole() {
        User::create([
            'name' => 'Admin',
            'email' => 'email2@test.abc',
            'password' => '$2y$10$TISWoOA9o26nqInTAOIxzOHTLnYI72RnmWik82n8K98Yukq8lsFaq' //password
        ])->assignRole('Admin');

        $token = $this->client->request('POST', '/api/auth/login', [
            'headers' => $this->headers,
            'json' => [
                'email' => 'email2@test.abc',
                'password' => 'password'
            ]
        ])->getBody();

        $token = json_decode($token)->token;

        $this->headers['Authorization'] = 'Bearer ' . $token;
        
        $response = $this->client->request('POST', '/api/auth/librarians', [
            'headers' => $this->headers,
            'json' => [
                'name' => 'user',
                'email' => 'emailabc@email.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        ]);

        $response = json_decode($response->getBody());

        $this->assertStringContainsString('ey', $response->token);
        $this->assertStringContainsString('Librarian', $response->user->roles[0]->name);
    }

    /** @test */
    public function whenRegisterClient_thenRegisterAndAssignRole() {
        $response = $this->client->request('POST', '/api/auth/clients', [
            'headers' => $this->headers,
            'json' => [
                'name' => 'user',
                'email' => 'email3@email.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        ]);

        $response = json_decode($response->getBody());

        $this->assertStringContainsString('ey', $response->token);
        $this->assertStringContainsString('Client', $response->user->roles[0]->name);
    }
}