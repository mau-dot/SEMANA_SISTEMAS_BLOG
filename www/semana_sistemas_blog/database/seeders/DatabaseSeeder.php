<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cuenta Integrante 1
        User::firstOrCreate(
            ['email' => 'gr23030@ues.edu.sv'],
            [
                'name' => 'Luis (Integrante 1)',
                'password' => Hash::make('admin123'),
            ]
        );

        // Cuenta Integrante 2
        User::firstOrCreate(
            ['email' => 'pg23022@ues.edu.sv'],
            [
                'name' => 'Mauricio (Integrante 2)',
                'password' => Hash::make('admin123'),
            ]
        );

        // Categorías iniciales para las 7 actividades
        $categories = [
            ['name' => 'Académico', 'slug' => 'academico'],
            ['name' => 'Deportivo', 'slug' => 'deportivo'],
            ['name' => 'Social y Convivencia', 'slug' => 'social-convivencia'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}