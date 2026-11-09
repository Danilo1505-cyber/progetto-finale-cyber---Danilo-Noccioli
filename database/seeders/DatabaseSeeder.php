<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crea un utente senza ruolo
      $user= User::create([
            'name' => 'Steven Manson (User)',
            'email' => 'user@aulab.it',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = false;
        $user->is_writer = false;
        $user->is_revisor = false;
        $user->save();

        // Crea un utente con ruolo writer
        $user = User::create([
            'name' => "Daria Richardson (Writer)",
            'email' => 'writer@aulab.it',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = false;
        $user->is_writer = true;
        $user->is_revisor = false;
        $user->save();

        // Crea un utente con ruolo revisor
        $user = User::create([
            'name' => "Antony Delgado (Revisor)",
            'email' => 'revisor@aulab.it',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = false;
        $user->is_writer = false;
        $user->is_revisor = true;
        $user->save();

        // Crea un amministratore
        $user = User::create([
            'name' => 'Steve Lorren (Admin)',
            'email' => 'admin@aulab.it',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = true;
        $user->is_writer = false;
        $user->is_revisor = false;
        $user->save();

        // Crea un super amministratore con tutti i ruoli
        $user = User::create([
            'name' => "Mario Bianchi (Super admin)",
            'email' => 'super.admin@aulab.it',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = true;
        $user->is_writer = true;
        $user->is_revisor = true;
        $user->save();

        // Crea un super amministratore con tutti i ruoli
        $user = User::create([
            'name' => "Kevin Ross (Attacker)",
            'email' => 'kvrs@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $user->is_admin = false;
        $user->is_writer = false;
        $user->is_revisor = false;
        $user->save();
    }
}
