<?php

namespace Api\WalletTrack\Domain\Repository;

use Api\WalletTrack\Domain\Interfaces\WalletTrackRepositoryInterface;
use Api\WalletTrack\Domain\Validation\ChangeWalletTrackValidate;
use Api\WalletTrack\Domain\Validation\cHashWalletTrackValidate;
use Api\WalletTrack\Domain\Validation\IdWalletTrackValidate;
use Api\WalletTrack\Domain\Validation\StoredWalletTrackValidate;
use Api\WalletTrack\Services\WalletTrackService;
use App\Factory\SerialKey\SerialKey;
use App\Models\WalletTrack;
use Illuminate\Http\Request;
use Exception;


/**
 * Class WalletRepository.
 */
class WalletTrackRepository extends WalletTrackService implements WalletTrackRepositoryInterface
{
    public function allWalletTrack(string $cHash): mixed
    {
        // Aqui queremos as configuração de transações somente do usuário
        $field = cHashWalletTrackValidate::exec(['cHash' => $cHash]);
        $wallet = WalletTrack::where($field)->get();
        return (!$wallet->isEmpty())? $wallet->toArray(): [];
    }

    public function findWalletTrack(string $cHash, int $id): mixed
    {
        // Valida se ID e cHash atende as regras.
        $field = array_merge(
            IdWalletTrackValidate::exec($id),
            cHashWalletTrackValidate::exec(['cHash' => $cHash])
        );
        // Aqui vamos trazer as configuração de transações somente do usuário
        $wallet = WalletTrack::where($field)->get();
        return (!$wallet->isEmpty())? $wallet->toArray(): [];
    }

    public function storedWalletTrack(Request $request): array
    {
        // valida se os campos atende as regras e retorna somente os campos que precisamos
        $fields = $request->all();
        $fields['cHash'] = $request->bearerToken();
        $fields['cTrack'] = SerialKey::getSerialKey();        
        $fields = StoredWalletTrackValidate::exec($fields);        
        $wallet = WalletTrack::create($fields);
        return $wallet->toArray();
    }

    public function changeWalletTrack(Request $request, int $id): array
    {
        $wallet = [];
        // valida se os campos atende as regras e retorna somente os campos que precisamos
        IdWalletTrackValidate::exec($id);
        $fields = ChangeWalletTrackValidate::exec($request->all());

        // Tipo de Moeda de uma Carteira só podem ser alteradas caso seu saldo seja zero.
        if (array_key_exists('cCoin', $fields)) {            
            if (!$this->walletTrackHasCoins($id, $fields)) {
                $wallet = WalletTrack::find($id)->update($fields);
            } else {
                throw new Exception('Tipo de Moeda de uma carteira só podem ser alterado, caso seu saldo seja zero.');
            }
        } else {
            $wallet = WalletTrack::find($id)->update($fields);
        }

        return ($wallet)? ['Message' => 'Update Success']: ['Message' => 'Update Fall. vide Documento'];
    }

    public function excludeWalletTrack(int $id): mixed
    {
        // Daqui não tem volta
        IdWalletTrackValidate::exec($id);

        // Transações de uma carteira só podem ser excluidas caso não tenha transações vinculas a ela.
        if (!$this->walletTrackHasTransactions($id)) {
            $users = WalletTrack::find($id)->delete();         
        }
        return ['Daqui não tem volta.'];
    }
}