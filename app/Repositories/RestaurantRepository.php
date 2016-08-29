<?php

namespace App\Repositories;

use App\Models\Restaurant;
use InfyOm\Generator\Common\BaseRepository;

class RestaurantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Restaurant::class;
    }
}
