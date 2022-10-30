<?php

namespace App\Repository;

use App\Repository\BaseRepository as BaseRepository;
use App\Repository\Contract\ImageInterface as ImageInterface;

use App\Image as Image;

class ImageRepository extends BaseRepository implements ImageInterface {

	protected $model;

	public function __construct(Image $image)
	{
		$this->model = $image;
	}

}