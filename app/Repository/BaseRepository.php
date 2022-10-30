<?php

namespace App\Repository;

use App\Repository\Contract\BaseInterface as BaseInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseInterface{

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}
	
	public function all()
    {
        return $this->model->all();
    }

    public function paginate($limit=15)
    {
        return $this->model->paginate($limit);
    }
    public function sortable($request)
    {
        if(isset($request['orderby']) && isset($request['sortby'])){
            return $this->model->orderBy($request['orderby'], $request['sortby']);
        }else{
            return $this->model;
        }
        
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}