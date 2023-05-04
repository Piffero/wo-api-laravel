<?php

namespace Api\Users\Services;

use Illuminate\Support\Facades\DB;

class UsersService
{
    public function createNewUser(array $fields): array
    {
        // vamos ordernar para que não tenhamos este tipo de erro.
        $cName = $fields['cName'];
        $cEmail = $fields['cEmail'];
        $cBirthday = $fields['cBirthday'];
        // Insere Usuario pela função assim já criaremos sua carteira e firmaremos contrato junto ao banco.
        return DB::select("SELECT fn_insert_new_user('$cName','$cEmail','$cBirthday') AS cHash");
    }   
}