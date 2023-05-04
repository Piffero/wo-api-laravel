<?php

namespace App\Http\Controllers;

use Api\Users\Domain\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
}
