<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use App\Client;
use App\Supervisor;
use App\Position;
use App\Jobsite;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminrole = Role::create(['name' => 'admin']);
        $adminpermission = Permission::create(['name' => 'admin.clients']);
        $adminrole->givePermissionTo($adminpermission);

        $clientrole = Role::create(['name' => 'client']);
        $clientpermission = Permission::create(['name' => 'client.jobsites']);
        $clientrole->givePermissionTo($clientpermission);

        $employeerole = Role::create(['name' => 'employee']);
        $employepermission = Permission::create(['name' => 'employee.jobsites']);
        $employeerole->givePermissionTo($employepermission);

        $supervisorrole = Role::create(['name' => 'supervisor']);
        $supervisorpermission = Permission::create(['name' => 'supervisor.jobsites']);
        $supervisorrole->givePermissionTo($supervisorpermission);

        //
        $user = new User();
        $user->name = 'Admin';
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'Super Admin';
        $user->username = 'superadmin';
        $user->password = bcrypt('superadmin');
        $user->save();
        $user->assignRole('superadmin');

        $user2 = new User();
        $user2->name = 'Client';
        $user2->username = 'client';
        $user2->password = bcrypt('client');
        $user2->save();
        $user2->assignRole('client');

        $client = new Client();
        $client->company_name = 'Comany 1';
        $client->user_id = $user2->id;
        $client->email = $user2->email;
        $client->office_phone = rand();
        $client->company_abn = rand();
        $client->office_address = rand();
        $client->status = 1;
        $client->save();

        $user3 = new User();
        $user3->name = 'Employee';
        $user3->username = 'employee';
        $user3->password = bcrypt('employee');
        $user3->save();
        $user3->assignRole('employee');

        $employee = new Employee();
        $employee->user_id = $user3->id;
        $employee->first_name = 'Employee';
        $employee->last_name = 'One';
        $employee->position_id = 1;
        $employee->account_name = rand();
        $employee->account_number = rand();
        $employee->account_bsb = rand();
        $employee->email = $user3->username.'@example.com';
        $employee->phone = rand();
        $employee->status = 1;
        $employee->save();

        $user4 = new User();
        $user4->name = 'Supervisor';
        $user4->username = 'supervisor';
        $user4->password = bcrypt('supervisor');
        $user4->save();
        $user4->assignRole('supervisor');

        $supervisor = new Supervisor();
        $supervisor->user_id = $user4->id;
        $supervisor->client_id = $client->id;
        $supervisor->first_name = 'supervisor';
        $supervisor->last_name = 'One';
        $supervisor->email = $user4->username.'@example.com';
        $supervisor->phone = rand();
        $supervisor->status = 1;
        $supervisor->save();

        $jobsite = new Jobsite();
        $jobsite->title = 'Jobsite 1';
        $jobsite->client_id = $client->id;
        $jobsite->save();

        $supervisor->jobsites()->attach($jobsite->id);
        $employee->jobsites()->attach($jobsite->id);

        $position = new Position();
        $position->title = 'Position 1';
        $position->description = 'Position 1';
        $position->save();
    }
}
