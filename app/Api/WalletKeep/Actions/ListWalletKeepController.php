<?php

namespace Api\WalletKeep\Actions;

use App\Http\Controllers\WalletKeepController;
use Illuminate\Http\Request;

class ListWalletKeepController extends WalletKeepController
{
    public function action(Request $request, string $cTrack, int $id = null)
    {                
        // Verifica se Id veio
        if (!empty($id)){                        
            return $this->repository->findWalletKeep($cTrack, $id);
        }
        
        return $this->repository->allWalletKeep($request, $cTrack);
    }
}
