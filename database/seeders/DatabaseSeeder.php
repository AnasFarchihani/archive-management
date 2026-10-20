<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;
use App\Models\Department;
use App\Models\StorageLocation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@miepeec.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'department_id' => null,
            'is_active' => true,
        ]);

        // 2. Departments
        $departments = [
            ['name' => 'Ressources Humaines', 'code' => 'RH'],
            ['name' => 'Finances', 'code' => 'FIN'],
            ['name' => 'Affaires Juridiques', 'code' => 'AJ'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept + ['is_active' => true]);
        }

        // 3. Regular user (beta test)

        $rh = Department::where('code', 'RH')->first();
        User::create([
            'name' => 'Utilisateur RH',
            'email' => 'user@miepeec.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER,
            'department_id' => $rh->id,
            'is_active' => true,
        ]);

        // 4. Storage sites
        StorageLocation::create([
            'name' => 'Armoire A1',
            'floor' => 'Rez-de-chaussée',
            'room' => 'Salle 101',
            'cabinet' => 'Armoire A',
            'shelf' => 'Étagère 1',
            'box' => 'Boîte 1',
            'is_active' => true,
        ]);

        StorageLocation::create([
            'name' => 'Armoire B2',
            'floor' => '1er étage',
            'room' => 'Salle 205',
            'cabinet' => 'Armoire B',
            'shelf' => 'Étagère 2',
            'box' => 'Boîte 5',
            'is_active' => true,
        ]);
    }
}
