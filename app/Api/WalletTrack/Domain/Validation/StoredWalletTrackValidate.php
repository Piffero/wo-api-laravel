<?php

namespace Api\WalletTrack\Domain\Validation;

use App\Exceptions\ValidateException;

abstract class StoredWalletTrackValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array 
    {
        $rules = [
            'cHash' => ['rules' => 'required|exact_length[32]', 'postdata' => $fields['cHash']],
            'cTrack' => ['rules' => 'required|exact_length[32]', 'postdata' => $fields['cTrack']],
            'cCoin' => ['rules' => 'required', 'postdata' => $fields['cCoin']],
            'nStartCurrent' => ['rules' => 'required|numeric', 'postdata' => $fields['nStartCurrent']]
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
