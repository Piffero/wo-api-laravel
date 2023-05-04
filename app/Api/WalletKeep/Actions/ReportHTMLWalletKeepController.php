<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;
use Illuminate\Http\Request;

class ReportHTMLWalletKeepController extends WalletKeepController
{
    public function action(Request $request)
    {
        
        // chamamos ReportWalletService que estende ao WalletKeepRepository;
        // vamos descobrir o que desejamos
        $typeReport = ($request->has('report'))? $request->report: false;
        if (!empty($typeReport)) {              
            if ($typeReport == 'all') {                
                return response()->json($this->repository->walletKeepReportAllTransaction($request), 200);
            }

            if ($typeReport == '30day') {
                return response()->json($this->repository->walletKeepReportLast30day($request));
            }
            
            if ($typeReport == 'monthyear') {
                $month = ($request->has('month'))? $request->month: now()->month();
                $year =  ($request->has('year'))? $request->year: now()->year();
                $monthYear = ['month' => $month, 'year' => $year];
                return response()->json($this->repository->walletKeepReportMonthYear($request, $monthYear));
            }
        }        
    }
}