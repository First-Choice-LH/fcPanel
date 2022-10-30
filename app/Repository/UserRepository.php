<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\UserInterface as UserInterface;

use App\User as User;

class UserRepository extends BaseRepository implements UserInterface{

	protected $model;

	public function __construct(User $user)
	{
		$this->model = $user;
    }
    // create a new record in the database
    public function createWithRole(array $data, $role)
    {
        return $this->model->create($data)->assignRole($role);
    }

    public function assignRole($role){
        return $this->model->assignRole($role);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->model->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }
        return $this->model->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        return null !== $this->model->roles()->whereIn('name', $roles)->first();
    }
    
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->model->roles()->where('name', $role)->first();
    }
}