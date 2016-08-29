<?php

use Faker\Factory as Faker;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;

trait MakeRestaurantTrait
{
    /**
     * Create fake instance of Restaurant and save it in database
     *
     * @param array $restaurantFields
     * @return Restaurant
     */
    public function makeRestaurant($restaurantFields = [])
    {
        /** @var RestaurantRepository $restaurantRepo */
        $restaurantRepo = App::make(RestaurantRepository::class);
        $theme = $this->fakeRestaurantData($restaurantFields);
        return $restaurantRepo->create($theme);
    }

    /**
     * Get fake instance of Restaurant
     *
     * @param array $restaurantFields
     * @return Restaurant
     */
    public function fakeRestaurant($restaurantFields = [])
    {
        return new Restaurant($this->fakeRestaurantData($restaurantFields));
    }

    /**
     * Get fake data of Restaurant
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRestaurantData($restaurantFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'address' => $fake->word,
            'open_time' => $fake->word,
            'category_id' => $fake->randomDigitNotNull,
            'close_time' => $fake->word,
            'phone_number' => $fake->word,
            'image' => $fake->word,
            'content' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $restaurantFields);
    }
}
