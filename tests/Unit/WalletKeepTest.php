<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WalletKeepTest extends TestCase
{
    public function testGettingWalletKeepApi() 
    {
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $walletTrack = DB::table('wallet_track')->where('cHash', $token)->get();
        $ctrack = $walletTrack[0]->cTrack;

        $response = $this->json('GET', "/api/keep/wallet/track/$ctrack", [], ['Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);        
    }

    public function testGettingWalletKeepDetailsApi() 
    {
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $walletTrack = DB::table('wallet_track')->where('cHash', $token)->get();
        $ctrack = $walletTrack[0]->cTrack;
        
        $response = $this->json('GET', "/api/keep/wallet/track/$ctrack/1", [], ['Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);        
    }

    public function testCreateInputWalletKeepApi()
    {
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $walletTrack = DB::table('wallet_track')->where('cHash', $token)->get();
        $ctrack = $walletTrack[0]->cTrack;

        $data = [
            "cTrack" => $ctrack,
            "nCurrent" => "1750.50",
            "cTransact" => "Input"
        ];

        $response = $this->json('POST', '/api/keep/wallet/open', $data, ['Authorization' => 'Bearer '.$token]);        
        $response->assertStatus(200);
    }

    public function testCreateOutputWalletKeepApi()
    {
        $user = DB::table('user')->where('id', '1')->get();
        $token = $user[0]->cHash;

        $walletTrack = DB::table('wallet_track')->where('cHash', $token)->get();
        $ctrack = $walletTrack[0]->cTrack;

        $data = [
            "cTrack" => $ctrack,
            "nCurrent" => "1750.50",
            "cTransact" => "Input"
        ];        

        $response = $this->json('POST', '/api/keep/wallet/open', $data, ['Authorization' => 'Bearer '.$token]);        
        $response->assertStatus(200);
    }    
    
}
