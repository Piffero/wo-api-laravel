<?php

namespace Api\WalletKeep\Domain\Repository;

use Api\WalletKeep\Domain\Interfaces\WalletKeepRepositoryInterface;
use Api\WalletKeep\Domain\Validation\cTrackWalletKeepValidate;
use Api\WalletKeep\Domain\Validation\IdWalletKeepValidate;
use Api\WalletKeep\Domain\Validation\RollbackWalletKeepValidate;
use Api\WalletKeep\Domain\Validation\StoredWalletKeepValidate;
use Api\WalletKeep\Services\WalletKeepService;
use App\Models\WalletKeep;
use Exception;
use Illuminate\Http\Request;

class WalletKeepRepository extends WalletKeepService implements WalletKeepRepositoryInterface
{
    public function allWalletKeep(Request $request, string $cTrack): mixed
    {
        // Aqui queremos as configuração de transações somente do usuário
        $field = cTrackWalletKeepValidate::exec(['cTrack' => $cTrack]);
        
        // Vamos lidar com a paginação
        $per_page = ($request->has('per_page'))? $request->per_page: 10;

        $wallet = WalletKeep::where($field)->paginate($per_page);
        return (!$wallet->isEmpty())? $wallet->toArray(): [];
    }

    public function findWalletKeep(string $cTrack, int $id): mixed
    {
        // Valida se ID e cHash atende as regras.
        $field = array_merge(
            IdWalletKeepValidate::exec($id),
            cTrackWalletKeepValidate::exec(['cTrack' => $cTrack])
        );
        // Aqui vamos trazer as transações do usuário
        $wallet = WalletKeep::where($field)->get();
        return (!$wallet->isEmpty())? $wallet->toArray(): [];
    }

    public function storedWalletKeep(Request $request): array
    {
        // valida se os campos atende as regras e retorna somente os campos que precisamos
        $fields = StoredWalletKeepValidate::exec($request->all());
        $wallet = WalletKeep::create($fields);
        return $wallet->toArray();
    }

    public function changeWalletKeep(Request $request, int $id): mixed
    {    
        // Daqui não tem como alterar uma Transação será atribuido o extorno
        IdWalletKeepValidate::exec($id);
        $fields = RollbackWalletKeepValidate::exec($request->all());
        
        // Transações de uma carteira, só podem ser extornadas caso tenha como sua ultima transação de debito,
        // o valor correspondente do extorno com data de criação no dia cprrente (hoje) vinculas a ela.
        if ($this->walletKeepHasLastTransactionsCurrentDate($id)) {
            if ($this->walletKeepHasLastOutputTransactionCurrentValue($fields['nCurrent'], $id)) {    
                            
                $lastTransaction = WalletKeep::find($id);       // Já sabemos que é altima transação então só busca.                
                $fields = [
                    'cTrack' => $lastTransaction->cTrack,
                    'nCurrent' => $lastTransaction->nCurrent,
                    'cTransact' => 'Rollback'
                ];

                // Validamos novamente os campos, não queremos perpetuar a sujeira no banco. e salvamos o extorno
                $fields = RollbackWalletKeepValidate::exec($fields);
                $wallet = WalletKeep::create($fields);
                return $wallet->toArray();
            } 
            throw new Exception('O valor da transação não corresponde com o última saída (saque)  efetuado.');
        } 
        throw new Exception('A transação não corresponde como última transação do dia atual.');
    }

    public function excludeWalletKeep(int $id): mixed
    {
        // Daqui não tem volta
        IdWalletKeepValidate::exec($id);
        
        // Transações de uma carteira, só podem ser excluidas caso seja a última e
        // a data de criação correspondente dia corrente (hoje) vinculas a ela.
        if ($this->walletKeepHasLastTransactionsCurrentDate($id)) {
            WalletKeep::find($id)->delete();       // Já sabemos que é altima transação então só deletar.
            return ['Message' => 'Daqui não tem volta.'];
        }
        throw new Exception('A transação não corresponde como última transação do dia atual.');
        
    }
}