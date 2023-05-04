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
        Schema::create('wallet_keep', function (Blueprint $table) {
            $table->id();
            $table->string('cTrack', 32)->index();
            $table->decimal('nCurrent', 8, 2);
            $table->enum('cTransact', ['Input', 'Output', 'Rollback']);
            $table->timestamps();
            $table->foreign('cTrack')->references('cTrack')->on('wallet_track');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_keep');
    }
};
