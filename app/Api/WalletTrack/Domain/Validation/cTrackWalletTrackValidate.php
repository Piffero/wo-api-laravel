<?php

namespace Api\WalletTrack\Domain\Validation;

use App\Exceptions\ValidateException;

abstract class cTrackWalletTrackValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array {
        return [
            'cHash' => ['rules' => 'required|exact_length[32]', 'postdata' => $fields['cHash']],            
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
