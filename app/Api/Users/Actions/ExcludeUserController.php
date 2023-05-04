<?php

namespace Api\Users\Actions;

use App\Http\Controllers\UserController;

class ExcludeUserController extends UserController
{
    public function action(int $id)
    {
        return response()->json($this->repository->excludeUser($id), 200);
    }
}
