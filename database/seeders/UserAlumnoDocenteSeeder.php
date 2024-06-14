<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAlumnoDocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Se crea un usuario general (Alumno)
        $general = \App\Models\User::create([
            'name' => 'Luis De la Cruz',
            'sid' => 'l.cruza',
            'tipo' => 'general',
            'email' => 'general@uah.es',
            'password' => bcrypt('12345678'),
        ]);

        $general->assignRole('general');

        // Se crea un usuario responsable (Docente)
        $responsable = \App\Models\User::create([
            'name' => 'Responsable',
            'sid' => 'r.esponsable',
            'tipo' => 'responsable',
            'email' => 'docente@uah.es',
            'password' => bcrypt('12345678'),
        ]);

        // Se crea un usuario responsable (Docente 2)
        $responsable = \App\Models\User::create([
            'name' => 'Responsable 2',
            'sid' => 'r.esponsable.2',
            'tipo' => 'responsable',
            'email' => 'docente2@uah.es',
            'password' => bcrypt('12345678'),
        ]);

        $responsable->assignRole('responsable');

        // Se crea un usuario administrador
        $administrador = \App\Models\User::create([
            'name' => 'Administrador',
            'sid' => 'a.dministrador',
            'tipo' => 'administrador',
            'email' => 'admin@uah.es',
            'password' => bcrypt('12345678'),
        ]);

        $administrador->assignRole('Administrador');
    }
}
