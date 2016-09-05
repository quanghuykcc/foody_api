<?php

use Faker\Factory as Faker;
use App\Models\FavoriteRestaurant;
use App\Repositories\FavoriteRestaurantRepository;

trait MakeFavoriteRestaurantTrait
{
    /**
     * Create fake instance of FavoriteRestaurant and save it in database
     *
     * @param array $favoriteRestaurantFields
     * @return FavoriteRestaurant
     */
    public function makeFavoriteRestaurant($favoriteRestaurantFields = [])
    {
        /** @var FavoriteRestaurantRepository $favoriteRestaurantRepo */
        $favoriteRestaurantRepo = App::make(FavoriteRestaurantRepository::class);
        $theme = $this->fakeFavoriteRestaurantData($favoriteRestaurantFields);
        return $favoriteRestaurantRepo->create($theme);
    }

    /**
     * Get fake instance of FavoriteRestaurant
     *
     * @param array $favoriteRestaurantFields
     * @return FavoriteRestaurant
     */
    public function fakeFavoriteRestaurant($favoriteRestaurantFields = [])
    {
        return new FavoriteRestaurant($this->fakeFavoriteRestaurantData($favoriteRestaurantFields));
    }

    /**
     * Get fake data of FavoriteRestaurant
     *
     * @param array $postFields
     * @return array
     */
    public function fakeFavoriteRestaurantData($favoriteRestaurantFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->randomDigitNotNull,
            'restaurant_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $favoriteRestaurantFields);
    }
}
