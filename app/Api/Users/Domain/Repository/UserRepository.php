<?php

namespace Api\Users\Domain\Repository;

use Api\Users\Domain\Interfaces\UserRepositoryInterface;
use Api\Users\Domain\Validation\ChangeUserValidate;
use Api\Users\Domain\Validation\IdUserValidate;
use Api\Users\Domain\Validation\StoredUserValidate;
use Api\Users\Services\UsersService;
use App\Models\Contract;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class UserRepository.
 */
class UserRepository extends UsersService implements UserRepositoryInterface
{
    public function allUsers(): mixed 
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return (!$users->isEmpty())? $users->toArray(): [];
    }

    public function findUser(int $id): mixed 
    {
        // Valida se ID atende as regras
        IdUserValidate::exec($id);
        $users = User::where('id', $id)->get();
        
        return (!$users->isEmpty())? $users->toArray(): [];
    }

    public function storedUser(Request $request): array
    {
        // valida se os campos atende as regras e retorna somente os campos que precisamos        
        $fields = StoredUserValidate::exec($request->all());        
        $user = $this->createNewUser($fields);
        return $user;
    }

    public function changeUser(Request $request, int $id): mixed
    {
        // valida se os campos atende as regras e retorna somente os campos que precisamos
        IdUserValidate::exec($id);
        $fields = ChangeUserValidate::exec($request->all());           
        $users = User::find($id)->update($fields);
        
        if($users) {
            return ['message' => 'Update Success.'];
        }
        return $users;
    }


    public function excludeUser(int $id): mixed 
    {
        // Daqui não tem volta 
        IdUserValidate::exec($id);        
        $users = User::find($id);
        $cHash = $users->cHash;

        Wallet::where('cHash', $cHash)->delete();
        $users->delete();
        Contract::where('cHash', $cHash)->delete();
        
        return ['Daqui não tem volta.'];
    }

}
