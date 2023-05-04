<?php

namespace Api\WalletKeep\Services;

use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletKeepService
{
    public function walletKeepHasLastTransactionsCurrentDate(int $id): bool
    {
        // Aqui vamos validar se o id informado tratase da utima transação de Hoje
        $walletKeep = DB::table('wallet_keep')->where('id', DB::raw('(select max(`id`) from wallet_keep)'))->get();        
        $created_at = DateTime::createFromFormat('Y-m-d H:s:i', $walletKeep[0]->created_at);
        $now = new DateTime();        
        return ($walletKeep[0]->id === $id && $created_at->diff($now)->d == 0);
    }

    public function walletKeepHasLastOutputTransactionCurrentValue(string $nCurrent, int $id): bool
    {
        // Aqui vamos validar se é a ultima transação, uma transação de saída (saque) e se o valor equivalente ao valor informado
        $walletKeep = DB::table('wallet_keep')->where('id', DB::raw('(select max(`id`) from wallet_keep)'))->get();        
        return ($walletKeep[0]->id === $id && $walletKeep[0]->nCurrent == $nCurrent && $walletKeep[0]->cTransact == 'Output');
    }

    public function walletKeepReportAllTransaction(Request $request): array
    {
        $cHash = $request->bearerToken();
        
        // carrega todas a transações do usuário
        $walletKeep = DB::table('wallet_keep as wk')
                        ->select('wt.cCoin', 'wk.cTrack', 'wk.nCurrent', 'wk.cTransact', 'wk.created_at', 'wk.updated_at')
                        ->join('wallet_track as wt', 'wt.cTrack', '=', 'wk.cTrack')
                        ->where('wt.cHash', $cHash)->get();
        
        return (!$walletKeep->isEmpty())?$walletKeep->toArray(): [];
    }

    public function walletKeepReportLast30day(Request $request): array
    {
        // carrega todas as transações do usuário nos ultimos 30 dias
        $cHash = $request->bearerToken();             
        $date = new DateTime();
        $subDays = $date->sub(new DateInterval('P30D'));
        $walletKeep = DB::table('wallet_keep as wk')
                        ->select('wt.cCoin', 'wk.cTrack', 'wk.nCurrent', 'wk.cTransact', 'wk.created_at', 'wk.updated_at')
                        ->join('wallet_track as wt', 'wt.cTrack', '=', 'wk.cTrack')
                        ->where('wt.cHash', $cHash)
                        ->where('wk.created_at', '>=', $subDays->format('Y-m-d H:s:i'))
                        ->get();        
        return (!$walletKeep->isEmpty())?$walletKeep->toArray(): [];
    }

    public function walletKeepReportMonthYear(Request $request, array $monthYear): array
    {
        // carrega todas as transações do usuário do mês e ano informado
        $cHash = $request->bearerToken();
        $walletKeep = DB::table('wallet_keep as wk')
                        ->select('wt.cCoin', 'wk.cTrack', 'wk.nCurrent', 'wk.cTransact', 'wk.created_at', 'wk.updated_at')
                        ->join('wallet_track as wt', 'wt.cTrack', '=', 'wk.cTrack')
                        ->where('wt.cHash', $cHash)
                        ->whereYear('wk.created_at', $monthYear['year'])
                        ->whereMonth('wk.created_at', $monthYear['month'])
                        ->get();
        
        return (!$walletKeep->isEmpty())?$walletKeep->toArray(): [];
    }

    // --------------------------------------------------------------------------------------------------
    // ------------- METODOS NOVO PARA CRIAR UM CABEÇALHO COM DADOS DO USUÁRIO E SEU SALDO --------------
    // --------------------------------------------------------------------------------------------------

    public function walletKeepReportHeader(Request $request): array 
    {
        $cHash = $request->bearerToken();
        $walletHeader = DB::table('user as u')
                          ->select('u.cName', 'u.cEmail', 'u.cBirthday', 'u.created_at', 'wt.nStartCurrent')
                          ->join('wallet_track as wt', 'wt.cHash', '=', 'u.cHash')
                          ->where('u.cHash', $cHash)
                          ->get();
        return (!$walletHeader->isEmpty())?$walletHeader->toArray(): [];
    }
}