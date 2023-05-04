<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;
use Exception;
use Illuminate\Http\Request;

class ChangeWalletKeepController extends WalletKeepController
{
    public function action(Request $request, int $id)
    {
        return $this->repository->changeWalletKeep($request, $id);
    }
}
