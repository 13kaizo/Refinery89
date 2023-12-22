<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            'department_name' => 'Alimentacion',
            // 'department_email' => Str::random(10).'@gmail.com',
        ]);

        Department::insert([
            'department_name' => 'Higiene',
            // 'department_email' => Str::random(10).'@gmail.com',
        ]);

        Department::insert([
            'department_name' => 'Carniceria',
            'department_parent_id' => 1,
        ]);

        Department::insert([
            'department_name' => 'Charcuteria',
            'department_parent_id' => 3,
        ]);

        Department::insert([
            'department_name' => 'Pescaderia',
            'department_parent_id' => 1,
        ]);

        Department::insert([
            'department_name' => 'Fruteria',
            'department_parent_id' => 1,
        ]);


        Department::insert([
            'department_name' => 'Peluqueria',
            'department_parent_id' => 2,
        ]);
    }
}
