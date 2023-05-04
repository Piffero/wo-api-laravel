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
        CREATE FUNCTION fn_get_serial_key() RETURNS varchar(32)
            DETERMINISTIC
            BEGIN
                SET @AResult = UPPER(LEFT(MD5(RAND()),5));
                SET @BResult = UPPER(LEFT(MD5(RAND()),6));
                SET @CResult = UPPER(LEFT(MD5(RAND()),6));
                SET @DResult = UPPER(LEFT(MD5(RAND()),6));
                SET @EResult = UPPER(LEFT(MD5(RAND()),5));

                RETURN (SELECT CONCAT(@AResult, '-', @BResult, '-', @CResult, '-', @DResult, '-', @EResult));
        END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS fn_get_serial_key');
    }
};
