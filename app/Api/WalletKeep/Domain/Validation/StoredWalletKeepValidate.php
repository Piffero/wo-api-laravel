<?php

namespace Api\WalletKeep\Domain\Validation;

use App\Exceptions\ValidateException;
use Exception;

abstract class StoredWalletKeepValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array 
    {
        if ($fields['cTransact'] == 'Rollback') {
            throw new Exception('Você não pode solicitar uma operação de extorno neste endpoint.');
        }


        $rules = [
            'cTrack' => ['rules' => 'required|exact_length[32]', 'postdata' => $fields['cTrack']],
            'nCurrent' => ['rules' => 'required|numeric', 'postdata' => $fields['nCurrent']],
            'cTransact' => ['rules' => 'required', 'postdata' => $fields['cTransact']]
        ];

        return $rules;
    }

    /**
     * Executa Validação.
     * @param $id
     */
    public static function exec(array $fields) 
    {
        $fields = self::rules_validate($fields);
        
        $extends = new ValidateException();
        $extends->validate($fields);
        if (!$extends->run()) {
            $extends->xErrorReporting();
        };

        return $extends->getFields();
    }

}
