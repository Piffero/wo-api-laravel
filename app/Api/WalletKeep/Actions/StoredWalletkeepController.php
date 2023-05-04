<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;
use Illuminate\Http\Request;

class StoredWalletkeepController extends WalletKeepController
{
    public function action(Request $request)
    {
        return $this->repository->storedWalletKeep($request);
    }
}
