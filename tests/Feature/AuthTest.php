<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

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
                'email' => 'email21aaazaa2wsa132zass3@sastest.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        ]);

        $this->assertStringContainsString('token', $response->getBody()->getContents());
    }
}
