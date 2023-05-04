<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;

class ExcludeWalletKeepController extends WalletKeepController
{
    public function action(int $id)
    {
        return response()->json($this->repository->excludeWalletKeep($id));
    }
}
