<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;
use App\Factory\CSV\CSV;
use Illuminate\Http\Request;

class ReportWalletKeepController extends WalletKeepController
{
    public function action(Request $request)
    {
        
        // chamamos ReportWalletService que estende ao WalletKeepRepository;
        // vamos descobrir o que desejamos
        $typeReport = ($request->has('report'))? $request->report: false;
        if (!empty($typeReport)) {
            $headerUser = $this->repository->walletKeepReportHeader($request);

            if ($typeReport == 'all') {                                
                $report = $this->repository->walletKeepReportAllTransaction($request);
                CSV::formatCSV($report, $headerUser);
            }

            if ($typeReport == '30day') {
                $report = $this->repository->walletKeepReportLast30day($request);
                CSV::formatCSV($report, $headerUser);
            }
            
            if ($typeReport == 'monthyear') {
                $month = ($request->has('month'))? $request->month: now()->month();
                $year =  ($request->has('year'))? $request->year: now()->year();                
                $monthYear = ['month' => $month, 'year' => $year];                
                $report = $this->repository->walletKeepReportMonthYear($request, $monthYear);
                CSV::formatCSV($report, $headerUser);
            }
        }        
    }
}