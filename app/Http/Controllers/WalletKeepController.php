<?php

namespace App\Http\Controllers;

use Api\WalletKeep\Domain\Repository\WalletKeepRepository;

class WalletKeepController extends Controller
{
    protected WalletKeepRepository $repository;

    public function __construct()
    {
        $this->repository = new WalletKeepRepository();
    }
}
