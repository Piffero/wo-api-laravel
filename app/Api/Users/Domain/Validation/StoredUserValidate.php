<?php

namespace Api\Users\Domain\Validation;

use App\Exceptions\ValidateException;

abstract class StoredUserValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array 
    {
        return [            
            'cName' => ['rules' => 'required', 'postdata' => $fields['cName']],
            'cEmail' => ['rules' => 'required|valid_email', 'postdata' => $fields['cEmail']],
            'cBirthday' => ['rules' => 'required|birthday', 'postdata' => $fields['cBirthday']],
        ];
    }

    /**
     * Executa Validação.
     * @param $id
     */
    public static function exec(array $fields) {        
        $fields = self::rules_validate($fields);
        
        $extends = new ValidateException();
        $extends->validate($fields);
        if (!$extends->run()) {
            $extends->xErrorReporting();
        };

        return $extends->getFields();
    }

}
