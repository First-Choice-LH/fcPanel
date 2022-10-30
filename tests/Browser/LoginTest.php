<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
        });
    }

    public function testAdminLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout');
            $browser->visit('/login')
                ->type('username','admin')
                ->type('password', 'admin')
                ->press('Login')
                ->assertPathIs('/employees');
        });
    }

    public function testSupervisorLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout');
            $browser->visit('/login')
                ->type('username','supervisor')
                ->type('password', 'supervisor')
                ->press('Login')
                ->assertPathIs('/supervisors/jobsites');
        });
    }

    public function testEmployeeLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout');
            $browser->visit('/login')
                ->type('username','employee')
                ->type('password', 'employee')
                ->press('Login')
                ->assertPathIs('/employees/jobsites');
        });
    }

    /*
    public function testAdminCompanyValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/clients/create')->press('Save')
                ->assertSee('The company name field is required')
                ->assertSee('The company abn must be a string')
                ->assertSee('The office address must be a string')
                ->assertSee('The office phone must be a string')
                ->assertSee('The admin email must be a valid email address')
                ->assertSee('The accounts email field is required');
        });
    }

    public function testAdminCompanyCreate()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/clients/create')
                ->type('company_name','admin'.rand().'@example.com')
                ->type('company_abn',rand())
                ->type('office_address',rand())
                ->type('office_phone',rand())
                ->type('admin_email','admin'.rand().'@example.com')
                ->type('accounts_email','admin'.rand().'@example.com')
                ->select('status', 1)
                ->press('Save')
                ->assertSee('Company List');

        });
    }


    public function testAdminLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->assertPathIs('/login');
        });
    }

    public function testEmployeeLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email','employee@example.com')
                ->type('password', 'employee')
                ->press('Login')
                ->assertPathIs('/employees/jobsites');
        });
    }


    public function testEmployeeLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->assertPathIs('/login');
        });
    }

    public function testSupervisorLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email','supervisor@example.com')
                ->type('password', 'supervisor')
                ->press('Login')
                ->assertPathIs('/supervisors/jobsites');
        });
    }

    public function testSupervisorLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')->assertPathIs('/login');
        });
    }
    */
}
