<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletKeep extends Model
{
    use HasFactory;

    protected $table = 'wallet_keep';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'cTrack',
        'nCurrent',
        'cTransact'        
    ];
}
