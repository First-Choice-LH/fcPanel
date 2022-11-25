<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getDownload(Request $request)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= $request->get('path');
        if(!$file) return;

        $headers = array(
            'Content-Type: application/pdf',
        );
        $tempArr    = \explode('/', $file);
        $filename   = \end( $tempArr );
        return response()->download($file, $filename, $headers);
    }
}
