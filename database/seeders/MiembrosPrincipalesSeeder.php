<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MiembrosPrincipalesSeeder extends Seeder
{
    public function run()
    {
        DB::table('miembrosprincipales')->insert([
            [
                'nombrecompleto' => 'Juan Perez',
                'documento' => '123456789',
                'telefono' => '5551234',
                'correo' => 'juan.perez@example.com',
                'id_pais' => 1,
                'fecha_registro' => now(),
                'fecha_nacimiento' => '1985-05-15',
                'sexo' => 'MASCULINO',
                'id_estadocivil' => 1,
                'id_estadomi' => 1,
                'miembros_hogar' => 4,
                'hijos' => 2,
                'hijos_menores' => 1,
                'id_permisore' => 1,
                'id_permisotra' => 1,
                'id_estadola' => 1,
                'id_red' => 1,
                'inicio_asignacion' => '2023-01-01',
                'fin_asignacion' => '2023-12-31',
                'codigointerno' => 'MP001',
                'id_user' => 2
            ],
            [
                'nombrecompleto' => 'Ana Gónez',
                'documento' => '987654321',
                'telefono' => '5555678',
                'correo' => 'ana.gomez@example.com',
                'id_pais' => 2,
                'fecha_registro' => now(),
                'fecha_nacimiento' => '1990-09-21',
                'sexo' => 'FEMENINO',
                'id_estadocivil' => 2,
                'id_estadomi' => 2,
                'miembros_hogar' => 3,
                'hijos' => 1,
                'hijos_menores' => 0,
                'id_permisore' => 2,
                'id_permisotra' => 2,
                'id_estadola' => 2,
                'id_red' => 2,
                'inicio_asignacion' => '2023-02-01',
                'fin_asignacion' => '2024-01-31',
                'codigointerno' => 'MP002',
                'id_user' => 2
            ],
            [
                'nombrecompleto' => 'Carlos Ramírez',
                'documento' => '456789123',
                'telefono' => '5559876',
                'correo' => 'carlos.ramirez@example.com',
                'id_pais' => 1,
                'fecha_registro' => now(),
                'fecha_nacimiento' => '1978-03-30',
                'sexo' => 'MASCULINO',
                'id_estadocivil' => 1,
                'id_estadomi' => 2,
                'miembros_hogar' => 5,
                'hijos' => 3,
                'hijos_menores' => 2,
                'id_permisore' => 1,
                'id_permisotra' => 2,
                'id_estadola' => 1,
                'id_red' => 2,
                'inicio_asignacion' => '2023-03-15',
                'fin_asignacion' => '2023-11-15',
                'codigointerno' => 'MP003',
                'id_user' => 2
            ],
            [
                'nombrecompleto' => 'María López',
                'documento' => '789123456',
                'telefono' => '5554321',
                'correo' => 'maria.lopez@example.com',
                'id_pais' => 2,
                'fecha_registro' => now(),
                'fecha_nacimiento' => '1982-12-10',
                'sexo' => 'FEMENINO',
                'id_estadocivil' => 2,
                'id_estadomi' => 1,
                'miembros_hogar' => 2,
                'hijos' => 1,
                'hijos_menores' => 1,
                'id_permisore' => 2,
                'id_permisotra' => 1,
                'id_estadola' => 2,
                'id_red' => 1,
                'inicio_asignacion' => '2023-04-01',
                'fin_asignacion' => '2023-10-01',
                'codigointerno' => 'MP004',
                'id_user' => 2
            ],
            [
                'nombrecompleto' => 'Luis Martínez',
                'documento' => '159753468',
                'telefono' => '5551111',
                'correo' => 'luis.martinez@example.com',
                'id_pais' => 1,
                'fecha_registro' => now(),
                'fecha_nacimiento' => '1995-07-05',
                'sexo' => 'MASCULINO',
                'id_estadocivil' => 1,
                'id_estadomi' => 2,
                'miembros_hogar' => 3,
                'hijos' => 2,
                'hijos_menores' => 1,
                'id_permisore' => 1,
                'id_permisotra' => 2,
                'id_estadola' => 1,
                'id_red' => 2,
                'inicio_asignacion' => '2023-05-01',
                'fin_asignacion' => '2024-04-30',
                'codigointerno' => 'MP005',
                'id_user' => 2
            ]
        ]);
    }
}
