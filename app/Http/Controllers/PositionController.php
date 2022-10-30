<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Contract\PositionInterface as PositionInterface;
use App\Http\Requests\PositionRequest as PositionRequest;
use App\Position;

class PositionController extends Controller
{
    //
	private $position;

    public function __construct(PositionInterface $position)
    {
    	$this->position = $position;
    }

    public function index(Request $request)
    {
        if(isset($request['orderby']) && isset($request['sortby'])){

           $data['rows'] = position::orderBy($request['orderby'], $request['sortby'])->paginate(15);
        }
        else{
           $data['rows'] = position::paginate(15);
        }
        return view('positions.list', $data);
    }

    public function create()
    {
        return view('positions.create');
    }

    public function update($id)
    {
        $data = [];
        $data['row'] = $this->position->show($id);
        
        return view('positions.create', $data);
    }

    public function save(PositionRequest $request)
    {
        $id = $request->input('id');

        $fields = [
            'client_id',
            'title',
            'description',
            'status'
        ];

        if($id == null){
            $this->position->create($request->only($fields));
        }else{
            $this->position->update($request->only($fields),$id);
        }

        return redirect('/positions/');
    }
}
