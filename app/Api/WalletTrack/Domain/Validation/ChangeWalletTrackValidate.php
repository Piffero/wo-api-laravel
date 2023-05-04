<?php

namespace Api\WalletTrack\Domain\Validation;

use App\Exceptions\ValidateException;

abstract class ChangeWalletTrackValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array 
    {
        $rules = [];
        if (array_key_exists('cCoin', $fields)) {
            $rules = array_merge($rules, ['cCoin' => ['rules' => 'required', 'postdata' => $fields['cCoin']]]);
        }

        if (array_key_exists('nStartCurrent', $fields)) {
            $rules = array_merge($rules, ['nStartCurrent' => ['rules' => 'required|numeric', 'postdata' => $fields['nStartCurrent']]]);
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
        
        $extends = new ValidateException();
        $extends->validate($fields);
        if (!$extends->run()) {
            $extends->xErrorReporting();
        };

        return $extends->getFields();
    }

}
