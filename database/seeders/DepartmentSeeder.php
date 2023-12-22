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
            'department_name' => 'Administration',
            // 'department_email' => Str::random(10).'@gmail.com',
        ]);

        Department::insert([
            'department_name' => 'Project',
            // 'department_email' => Str::random(10).'@gmail.com',
        ]);

        Department::insert([
            'department_name' => 'Sales Department',
            'department_parent_id' => 1,
        ]);

        Department::insert([
            'department_name' => 'Product Development',
            'department_parent_id' => 2,
        ]);
    
        Department::insert([
            'department_name' => 'Design',
            'department_parent_id' => 4,
        ]);

        Department::insert([
            'department_name' => 'Operations',
            'department_parent_id' => 1,
        ]);

    }

}
