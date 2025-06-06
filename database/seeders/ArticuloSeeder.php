<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Articulo;


class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            Articulo::create([
                'nombre' => "Artículo $i",
                'descripcion' => "Descripción del artículo $i con características detalladas.",
                'precio' => rand(10000, 50000),
                'stock' => rand(1, 50),
                'imagen' => "articulo$i.jpg", // Luego los subiremos o los pondremos genéricos
                'categoria' => ['Celulares', 'Video juegos', 'Computadores', 'Escritorios'][rand(0, 3)],
            ]);
        }
    }
}
