<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = new User();
        // $user->name = 'Nadeen';
        // $user->username = 'nadeen';
        // $user->password = bcrypt('FCNadeen!23');
        // $user->save();
        // $user->assignRole('admin');


        // $user = new User();
        // $user->name = 'Aya';
        // $user->username = 'Aya';
        // $user->password = bcrypt('FCAya!23');
        // $user->save();
        // $user->assignRole('admin');

        // $user = new User();
        // $user->name = 'Kati';
        // $user->username = 'kati';
        // $user->password = bcrypt('FCKati!23');
        // $user->save();
        // $user->assignRole('admin');

        Role::create(['name' => 'staff']);
        Role::create(['name' => 'allocator']);

        $user = new User();
        $user->name = 'Bill';
        $user->username = 'bill';
        $user->password = bcrypt('FCBill!23');
        $user->save();
        $user->assignRole('staff');

        $user = new User();
        $user->name = 'Sam';
        $user->username = 'sam';
        $user->password = bcrypt('FCSam!23');
        $user->save();
        $user->assignRole('staff');

        $user = new User();
        $user->name = 'Sathia';
        $user->username = 'sathia';
        $user->password = bcrypt('FCSathia!23');
        $user->save();
        $user->assignRole('allocator');

    }
}
