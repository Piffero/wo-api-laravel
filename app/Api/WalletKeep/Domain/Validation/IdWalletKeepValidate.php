<?php

namespace Api\WalletKeep\Domain\Validation;

use App\Exceptions\ValidateException;

abstract class IdWalletKeepValidate
{
    /**
     * Definimos a regra de validação 
     * @param $fields ['NomeCampo'=>String]
     */
    private static function rules_validate(array $fields): array {
        return [
            'id' => ['rules' => 'required|integer', 'postdata' => $fields['id']]
        ];
    }

    /**
     * Executa Validação.
     * @param $id
     */
    public static function exec(int $id) {
        $fields = self::rules_validate(['id' => $id]);
        
        $extends = new ValidateException();
        $extends->validate($fields);
        if (!$extends->run()) {
            $extends->xErrorReporting();
        };

        return $extends->getFields();
    }

}
