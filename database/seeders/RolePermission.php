<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nom'     => 'clayer',
                'prenom'  => 'yannick',
                'password' => Hash::make('motdepasse1234'),
                'is_actif' => true,
                'must_change_password' => true,

            ]
        );

        $adminUser->assignRole('admin');
    }
}
