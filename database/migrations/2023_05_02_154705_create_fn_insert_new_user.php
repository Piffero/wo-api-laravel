<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("        
        CREATE FUNCTION fn_insert_new_user(cName varchar(120), cEmail varchar(180), cBirthday varchar(255)) 
            RETURNS varchar(65)
            DETERMINISTIC
            BEGIN
                SET @sk_regs_i = fn_get_serial_key();
                INSERT INTO `contract` (`cHash`, `created_at`, `updated_at`) VALUES (@sk_regs_i, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
                INSERT INTO `user` (`cHash`, `cName`, `cEmail`, `cBirthday`, `created_at`, `updated_at`) VALUES (@sk_regs_i, cName, cEmail, cBirthday,CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
                INSERT INTO `wallet` (`cHash`, `created_at`, `updated_at`) VALUES (@sk_regs_i, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
                                
                RETURN @sk_regs_i;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS fn_insert_new_user');
    }
};
