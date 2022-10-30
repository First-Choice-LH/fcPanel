<?php

namespace App\Providers;

use App\Repository\Contract\UserInterface as UserInterface;
use App\Repository\UserRepository as UserRepository;

use App\Repository\Contract\ClientInterface as ClientInterface;
use App\Repository\ClientRepository as ClientRepository;

use App\Repository\Contract\SupervisorInterface as SupervisorInterface;
use App\Repository\SupervisorRepository as SupervisorRepository;

use App\Repository\Contract\EmployeeInterface as EmployeeInterface;
use App\Repository\EmployeeRepository as EmployeeRepository;

use App\Repository\Contract\JobsiteInterface as JobsiteInterface;
use App\Repository\JobsiteRepository as JobsiteRepository;

use App\Repository\Contract\PositionInterface as PositionInterface;
use App\Repository\PositionRepository as PositionRepository;

use App\Repository\Contract\TimesheetInterface as TimesheetInterface;
use App\Repository\TimesheetRepository as TimesheetRepository;

use App\Repository\Contract\ImageInterface as ImageInterface;
use App\Repository\ImageRepository as ImageRepository;


use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {        
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ClientInterface::class,
            ClientRepository::class
        );

        $this->app->bind(
            SupervisorInterface::class,
            SupervisorRepository::class
        );

        $this->app->bind(
            EmployeeInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            JobsiteInterface::class,
            JobsiteRepository::class
        );
        
        $this->app->bind(
            PositionInterface::class,
            PositionRepository::class
        );
        
        $this->app->bind(
            TimesheetInterface::class,
            TimesheetRepository::class
        );
        
        $this->app->bind(
            ImageInterface::class,
            ImageRepository::class
        );
    }
}
