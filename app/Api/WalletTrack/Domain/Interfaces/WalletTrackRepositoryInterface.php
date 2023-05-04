<?php

namespace Api\WalletTrack\Domain\Interfaces;

use Illuminate\Http\Request;

Interface WalletTrackRepositoryInterface 
{
    public function allWalletTrack(string $cHash): mixed;
    public function storedWalletTrack(Request $request): array;
    public function findWalletTrack(string $cHash, int $id): mixed;
    public function changeWalletTrack(Request $request, int $id): array;
    public function excludeWalletTrack(int $id): mixed;
}
