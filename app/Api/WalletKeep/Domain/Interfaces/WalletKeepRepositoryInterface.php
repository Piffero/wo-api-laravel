<?php

namespace Api\WalletKeep\Domain\Interfaces;

use Illuminate\Http\Request;

Interface WalletKeepRepositoryInterface 
{
    public function allWalletKeep(Request $request, string $cTrack): mixed;
    public function findWalletKeep(string $cTrack, int $id): mixed;
    public function storedWalletKeep(Request $request): array;
    public function changeWalletKeep(Request $request, int $id): mixed;
    public function excludeWalletKeep(int $id): mixed;
}
