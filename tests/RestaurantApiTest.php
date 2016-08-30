<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RestaurantApiTest extends TestCase
{
    use MakeRestaurantTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRestaurant()
    {
        $restaurant = $this->fakeRestaurantData();
        $this->json('POST', '/api/v1/restaurants', $restaurant);

        $this->assertApiResponse($restaurant);
    }

    /**
     * @test
     */
    public function testReadRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $this->json('GET', '/api/v1/restaurants/'.$restaurant->id);

        $this->assertApiResponse($restaurant->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $editedRestaurant = $this->fakeRestaurantData();

        $this->json('PUT', '/api/v1/restaurants/'.$restaurant->id, $editedRestaurant);

        $this->assertApiResponse($editedRestaurant);
    }

    /**
     * @test
     */
    public function testDeleteRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $this->json('DELETE', '/api/v1/restaurants/'.$restaurant->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/restaurants/'.$restaurant->id);

        $this->assertResponseStatus(404);
    }
}
