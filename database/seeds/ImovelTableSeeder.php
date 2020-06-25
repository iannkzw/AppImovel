<?php

use Illuminate\Database\Seeder;

class ImovelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory('App\Imovel', 20)->create();
    }
}
