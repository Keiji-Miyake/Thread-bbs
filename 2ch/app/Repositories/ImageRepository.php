<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * ImageRepository constructor.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Create new Image.
     *
     * @param array $data
     * @return Image $image
     */
    public function create(array $data)
    {
        return $this->image->create($data);
    }
}
