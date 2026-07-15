<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => Department::ADMIN,      'description' => 'System administration'],
            ['name' => Department::SALES,      'description' => 'Takes orders from customers'],
            ['name' => Department::PURCHASING, 'description' => 'Manages purchase of materials'],
            ['name' => Department::WAREHOUSE,  'description' => 'Prepares orders for routing'],
            ['name' => Department::ROUTE,      'description' => 'Distributes orders to customers'],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(['name' => $department['name']], $department);
        }
    }
}
