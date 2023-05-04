<?php

namespace Api\WalletTrack\Actions;

use App\Http\Controllers\WalletTrackController;
use Illuminate\Http\Request;

class StoredWalletTrackController extends WalletTrackController
{
    public function action(Request $request)
    {
        return $this->repository->storedWalletTrack($request);
    }
}