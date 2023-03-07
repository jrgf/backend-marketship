<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            'nombre'=>'Rosario de madera',
            'precio'=>125.00,
            'imagen'=>'rosario1',
            'stock'=>10,
            'disponible'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()

        ]);
        DB::table('productos')->insert([
            'nombre'=>'Gato de la suerte grande',
            'precio'=>250.00,
            'imagen'=>'gato1',
            'stock'=>5,
            'disponible'=>1,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()

        ]);
        DB::table('productos')->insert([
            'nombre'=>'Gato de la suerte mediano',
            'precio'=>150.00,
            'imagen'=>'gato2',
            'disponible'=>1,
            'stock'=>4,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()

        ]);
        DB::table('productos')->insert([
            'nombre'=>'Gato de la suerte pequeño',
            'precio'=>90.00,
            'imagen'=>'gato3',
            'stock'=>6,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()

        ]);
    }
}
