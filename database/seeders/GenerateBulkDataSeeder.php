<?php

namespace Database\Seeders;

use App\Factory\SerialKey\SerialKey;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateBulkDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = new DateTime();
        for ($i=0; $i < 10; $i++) { 
            $cHash = SerialKey::getSerialKey();
            DB::table('contract')->insert([
                'cHash' => $cHash,
                'created_at' => $now->format('Y-m-d H:s:i'),
                'updated_at' => $now->format('Y-m-d H:s:i')
            ]);

            $date = new DateTime('2005-03-10');
            
            DB::table('user')->insert([
                'cHash' => $cHash,
                'cName' => Str::random(10),
                'cEmail' => Str::random(10).'@malinator.com',
                'cBirthday' => $date->format('Y-m-d'),
                'created_at' => $now->format('Y-m-d H:s:i'),
                'updated_at' => $now->format('Y-m-d H:s:i')
            ]);

            DB::table('wallet')->insert([
                'cHash' => $cHash,
                'created_at' => $now->format('Y-m-d H:s:i'),
                'updated_at' => $now->format('Y-m-d H:s:i')
            ]);

            $cTrack = SerialKey::getSerialKey();
            DB::table('wallet_track')->insert([
                'cHash' => $cHash,
                'cTrack' => $cTrack,
                'cCoin' => 'Cash',
                'nStartCurrent' => random_int(100, 999),
                'created_at' => $now->format('Y-m-d H:s:i'),
                'updated_at' => $now->format('Y-m-d H:s:i')
            ]);

            for ($j=0; $j < 20; $j++) { 
                DB::table('wallet_keep')->insert([
                    'cTrack' => $cTrack,
                    'nCurrent' => random_int(10, 99),
                    'cTransact' => 'Input',
                ]);
            }
            
        }
    }
}
