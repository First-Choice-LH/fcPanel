<?php

use Illuminate\Database\Seeder;
use App\User;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Nadeen';
        $user->username = 'nadeen';
        $user->password = bcrypt('FCNadeen!23');
        $user->save();
        $user->assignRole('admin');


        $user = new User();
        $user->name = 'Aya';
        $user->username = 'Aya';
        $user->password = bcrypt('FCAya!23');
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'Kati';
        $user->username = 'kati';
        $user->password = bcrypt('FCKati!23');
        $user->save();
        $user->assignRole('admin');
    }
}
