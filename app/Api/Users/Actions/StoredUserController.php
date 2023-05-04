<?php

namespace Api\Users\Actions;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

class StoredUserController extends UserController
{
    public function action(Request $request)
    {
        return $this->repository->storedUser($request);
    }
}
