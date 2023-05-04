<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_track', function (Blueprint $table) {
            $table->id();
            $table->string('cHash', 32)->index();
            $table->string('cTrack', 32)->index()->unique();
            $table->string('cCoin');
            $table->timestamps();
            $table->unique(['cHash', 'cTrack']);
            $table->foreign('cHash')->references('cHash')->on('wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_track');
    }
};
