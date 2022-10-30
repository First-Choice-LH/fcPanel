<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Contract\JobsiteInterface as JobsiteInterface;

class ApiController extends Controller
{
    private $jobsite;

    public function __construct(JobsiteInterface $jobsite){
        $this->jobsite = $jobsite;
    }
    
    public function client_jobsites($id=0){
        $jobsites = $this->jobsite->byClientId($id);
        return $jobsites->toJSON();
    }
    public function encryptProject(){

    }
}
