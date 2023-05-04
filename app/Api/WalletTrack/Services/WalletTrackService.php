<?php

namespace Api\WalletTrack\Services;

use Illuminate\Support\Facades\DB;

class WalletTrackService
{
    public function walletTrackHasCoins(int $walletTrack_id): bool
    {
        $soma = 0;
        $wallet_trak = DB::table('wallet_track as wt')
            ->select('wt.cHash', 'wt.cTrack', 'wt.nStartCurrent')
            ->selectSub("SELECT SUM(nCurrent) FROM wallet_keep WHERE cTrack = wt.cTrack AND cTransact = 'Input'" , 'input')
            ->selectSub("SELECT SUM(nCurrent) FROM wallet_keep WHERE cTrack = wt.cTrack AND cTransact = 'Output'" , 'output')
            ->selectSub("SELECT SUM(nCurrent) FROM wallet_keep WHERE cTrack = wt.cTrack AND cTransact = 'Rollback'" , 'rollback')
            ->where('wt.id', $walletTrack_id)            
            ->join('wallet_keep as wk', 'wk.cTrack', '=', 'wt.cTrack')
            ->get();

        if (!$wallet_trak->isEmpty()) {
            $soma = array_sum([$wallet_trak->input, $wallet_trak->rollback]);
            $soma -= $wallet_trak->output;        
        }
        
        return (!$soma === 0);
    }

    public function walletTrackHasTransactions(int $walletTrack_id): bool
    {
        $wallet_trak = DB::table('walletTrack as wt')
            ->where('wt.id', $walletTrack_id)
            ->join('wk.wallet_keep', 'wk.cTrack', '=', 'wt.cTrack')
            ->get();

        return (!$wallet_trak->isEmpty());
    }
}