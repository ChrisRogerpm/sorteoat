<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Models\TblGeneracionOpcionesSorteo::class,100000)->create();
        //factory(App\Models\TblConsolidadoOpcionesSorteo::class,1000)->create();        
        factory(App\Models\TblCliente::class,100)->create();
    }
}
