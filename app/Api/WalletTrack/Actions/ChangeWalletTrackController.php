<?php

namespace Api\WalletTrack\Actions;

use App\Http\Controllers\WalletTrackController;
use Exception;
use Illuminate\Http\Request;

class ChangeWalletTrackController extends WalletTrackController
{
    public function action(Request $request, int $id)
    {        
        return response()->json($this->repository->changeWalletTrack($request, $id), 200);
    }
}
