<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminDepartment = Department::where('name', Department::ADMIN)->first();

        User::updateOrCreate(
            ['email' => 'admin@halcon.com'],
            [
                'name'              => 'System Administrator',
                'password'          => Hash::make('admin123'),
                'department_id'     => $adminDepartment?->id,
                'active'            => true,
                'email_verified_at' => now(),
            ]
        );

        // Un usuario por cada departamento operativo, para poder probar el flujo completo.
        $operationalUsers = [
            ['name' => 'Sales Demo User',      'email' => 'sales@halcon.com',      'department' => Department::SALES],
            ['name' => 'Purchasing Demo User', 'email' => 'purchasing@halcon.com', 'department' => Department::PURCHASING],
            ['name' => 'Warehouse Demo User',  'email' => 'warehouse@halcon.com',  'department' => Department::WAREHOUSE],
            ['name' => 'Route Demo User',      'email' => 'route@halcon.com',      'department' => Department::ROUTE],
        ];

        foreach ($operationalUsers as $data) {
            $department = Department::where('name', $data['department'])->first();

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('password'),
                    'department_id'     => $department?->id,
                    'active'            => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
