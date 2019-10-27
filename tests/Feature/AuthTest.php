<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

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
        
    }

    /** @test */
    public function whenRegisterUser_thenRegisterAndReturnToken() {
        $response = $this->client->request('POST', '/api/auth/register', [
            'headers' => $this->headers,
            'json' => [
                'name' => 'user',
                'email' => 'email@email.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        ]);

        $this->assertStringContainsString('token', $response->getBody()->getContents());
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
                'email' => 'email@email.com',
                'password' => 'password',
            ]
        ]);

        $this->assertStringContainsString('token', $response->getBody()->getContents());
    }
}