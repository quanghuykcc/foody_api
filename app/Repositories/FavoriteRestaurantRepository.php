<?php

namespace App\Repositories;

use App\Models\FavoriteRestaurant;
use InfyOm\Generator\Common\BaseRepository;

class FavoriteRestaurantRepository extends BaseRepository
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
        return FavoriteRestaurant::class;
    }
}
