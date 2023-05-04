<?php

namespace Api\Users\Domain\Validation;

use App\Exceptions\ValidateException;
use Exception;

abstract class ChangeUserValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array 
    {
        $rules = [];        
        if (array_key_exists('cName', $fields)) {
            $rules = array_merge($rules, [
                'cName' => ['rules' => 'required', 'postdata' => $fields['cName']]
            ]);
        }
        if (array_key_exists('cEmail', $fields)) {
            $rules = array_merge($rules, [
                'cMail' => ['rules' => 'required|valid_email', 'postdata' => $fields['cEmail']]
            ]);
        }
        if (array_key_exists('cBirthday', $fields)) {
            $rules = array_merge($rules, [
                'cBirthday' => ['rules' => 'required', 'postdata' => $fields['cBirthday']]
            ]);
        }
        return $rules;
    }

    /**
     * Executa Validação.
     * @param $id
     */
    public static function exec(array $fields) 
    {
        $fields = self::rules_validate($fields);
        if (empty($fields)) {
            throw new Exception('Os Campos enviados não atende os esperados pela API. Contate administrador do sistema ou vide Documentação.');
        }
        
        $extends = new ValidateException();
        $extends->validate($fields);
        if (!$extends->run()) {
            $extends->xErrorReporting();
        };

        return $extends->getFields();
    }

}
