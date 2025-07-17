<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Lowella Viray', 'email' => 'louie.viray@hsac.gov.ph'],
            ['name' => 'John Henry Canas', 'email' => 'johnry.canas@hsac.gov.ph'],
            ['name' => 'Rj Cabarong', 'email' => 'rj.cabarong@hsac.gov.ph'],
            ['name' => 'Joel Manaloto Jr.', 'email' => 'joel.manaloto@hsac.gov.ph'],
            ['name' => 'Patrick Jade Bacud', 'email' => 'patrick.bacud@hsac.gov.ph'],
            ['name' => 'Fidel J. Exconde Jr.', 'email' => 'fidel.excondejr@hsac.gov.ph'],
            ['name' => 'Sergio E. Yap II', 'email' => 'sergio.yapii@hsac.gov.ph'],
            ['name' => 'John-Christopher T. Mahamud', 'email' => 'john-christopher.mahamud@hsac.gov.ph'],
            ['name' => 'Michael P. Cloribel', 'email' => 'commissioner.cloribel@hsac.gov.ph'],
        ];

        $now = \Carbon\Carbon::now();

        foreach ($users as &$user) {
            $user['password'] = Hash::make('Password@123');
            $user['created_at'] = $now;
            $user['updated_at'] = $now;
        }

        DB::table('users')->insert($users);
    }
}
