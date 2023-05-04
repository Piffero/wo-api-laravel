<?php

namespace App\Http\Controllers;

use Api\WalletTrack\Domain\Repository\WalletTrackRepository;
use Illuminate\Http\Request;

class WalletTrackController extends Controller
{
    protected WalletTrackRepository $repository;

    public function __construct()
    {
        $this->repository = new WalletTrackRepository();
    }
}
