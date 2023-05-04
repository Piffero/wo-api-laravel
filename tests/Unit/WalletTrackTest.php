<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WalletTrackTest extends TestCase
{
    public function testCreateWalletStartCurrentApi()
    {
        $data = [
            "cCoin" => "Cash",
            "nStartCurrent" => "1754.00"
        ];

        $user = DB::table('user')->where('id', DB::raw('(select max(`id`) from user)'))->get();
        $token = $user[0]->cHash;

        $response = $this->json('POST', '/api/user/wallet', $data, ['Authorization' => 'Bearer '.$token]);  
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                "cHash",
                "cTrack",
                "cCoin",
                "nStartCurrent",
                "updated_at",
                "created_at",
                "id"
            ]
        );
    }


}
