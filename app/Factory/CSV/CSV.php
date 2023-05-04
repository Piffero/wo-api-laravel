<?php

namespace App\Factory\CSV;

abstract class CSV
{
    public static function formatCSV(array $data, array $dataHeader = null)
    {        
        $time = now()->format('yyyy.mm.dd.hh.nn.ss');  
        $image_name = 'transaction_'.$time.'.csv';        
        $fp = fopen($image_name, 'w');        
        
        // vamos verificar se $dataHeader foi preenchido        
        if (!empty($dataHeader)) {
            // caso tenha sido, colocaremos junto a primeira linha.                        
            fputcsv($fp, self::createHeaderUser($dataHeader)); 

            /* 
                Escolheremos extender a uma funcionalidade para manutenções futuras
                caso venha a ter usuários que não queram suas informações junto ao relatório.

                Assim podende fazer este tipo de validação junto a funcionalidade que se extende, 
                não inchando a funcionalidade principal.
            */
        }

        $header = [];
        foreach ($data as $row) {
            $header = array_keys((array) $row);
            break;
        }        
        fputcsv($fp, $header);
            
        $rows = [];
        foreach ($data as $row) {
            $rows = array_merge($rows, array_values((array) $row));
        }        
        fputcsv($fp, $rows);
        fclose($fp);
        
        readfile($image_name);
    }

    private static function createHeaderUser($dataHeader = null): array
    {                
        $headerUser = [];
        foreach ($dataHeader as $row)
        {
            // code ... aqui poderia ter aquele (if) se o usuário quer seus dados ou não junto ao relatório
            $headerUser = array_values((array) $row);         
        }
        return $headerUser;
    }
}