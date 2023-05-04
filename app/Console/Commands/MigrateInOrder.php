<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-in-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** Specify the names of the migrations files in the order you want to 
        * loaded
        * $migrations =[ 
        *               'xxxx_xx_xx_000000_create_nameTable_table.php',
        *    ];
        */

        $migrations = [
            '2023_05_01_161929_create_contract_table.php',
            '2023_05_01_160535_create_user_table.php',
            '2023_05_01_162403_create_wallet_table.php',
            '2023_05_01_162608_create_wallet_track_table.php',
            '2023_05_01_164354_create_wallet_keep_table.php',            
            '2023_05_02_154027_create_fn_get_serial_key.php',
            '2023_05_02_154705_create_fn_insert_new_user.php'            
        ];

        foreach ($migrations as $migration)
        {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate:refresh', ['--path' => $path]);
        }
    }
}
