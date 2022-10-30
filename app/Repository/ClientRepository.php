<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\ClientInterface as ClientInterface;

use App\Client as Client;

class ClientRepository extends BaseRepository implements ClientInterface{

	protected $model;

	public function __construct(Client $client)
	{
		$this->model = $client;
	}

	public function getClientId($id)
	{
		return $this->model->where('user_id',$id)->first();
	}

	public function dropdown(){
		return $this->model->where('status',1)->get()->keyBy('id');
	}

	public function paginateByClient($id)
	{
		return $this->model->findOrFail($id)->jobsites()->paginate();
	}

	public function paginateByJobsite($client_id,$jobsite_id)
	{
		return $this->model->find($client_id)->jobsites()->find($jobsite_id)->first()->employee()->paginate();
	}
}