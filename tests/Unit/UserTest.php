<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testGettingUserApi() 
    {        
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;
        
        $response = $this->json('GET', '/api/users', [], ['Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);        
        $response->assertJsonStructure(
            [
                [
                    "id",
                    "cHash",
                    "cName",
                    "cEmail",
                    "cBirthday",
                    "created_at",
                    "updated_at",
                ]
            ]
        );
    }

    public function testGettingUserDetailsApi() 
    {
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $response = $this->json('GET', '/api/users/1', [], ['Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);        
        $response->assertJsonStructure(
            [
                [
                    "id",
                    "cHash",
                    "cName",
                    "cEmail",
                    "cBirthday",
                    "created_at",
                    "updated_at",
                ]
            ]
        );
    }

    public function testCreateUserApi()
    {
        $numberRand = rand();
        $data = [
            "cName" => "Fulano da Silva $numberRand",
            "cEmail" => "fulano.silva.$numberRand@malinator.com",
            "cBirthday" => "2005-03-10"
        ];

        $token = '1BDF7-C97720-DC2722-27B70A-18957';
        $response = $this->json('POST', '/api/users', $data);
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                    "cHash",
                ]
            ]
        );
    }

    public function testUpdateUserApi()
    {
        $numberRand = rand();
        $data = [            
            "cEmail" => "fulano.silva.$numberRand@malinator.com",            
        ];

        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $token = '1BDF7-C97720-DC2722-27B70A-18957';
        $response = $this->json('PUT', '/api/users/1', $data, ['Authorization' => 'Bearer '.$token]);        
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'message'
            ]
        );
    }
    

    public function testDeleteUserApi()
    {        
        $user = DB::table('user')->where('id', DB::raw('(select max(`id`) from user)'))->get();
        $token = $user[0]->cHash;
        $response = $this->json('DELETE', '/api/users/'.$user[0]->id, [], ['Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);
    }
    
}
