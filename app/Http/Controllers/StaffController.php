<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class StaffController extends Controller
{

    public function index(Request $request){

        $data['rows']       = User::role(['admin', 'allocator', 'staff'])->paginate(15);
        return view('staff.list', $data);
    }
}
