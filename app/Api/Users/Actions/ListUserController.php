<?php

namespace Api\Users\Actions;

use App\Http\Controllers\UserController;

class ListUserController extends UserController
{
    public function action($id = null)
    {        
        // Verifica se Id veio
        if (!empty($id)){                        
            return $this->repository->findUser($id);
        }
        
        return $this->repository->allUsers();
    }
}
