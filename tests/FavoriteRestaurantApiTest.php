<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteRestaurantApiTest extends TestCase
{
    use MakeFavoriteRestaurantTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->fakeFavoriteRestaurantData();
        $this->json('POST', '/api/v1/favoriteRestaurants', $favoriteRestaurant);

        $this->assertApiResponse($favoriteRestaurant);
    }

    /**
     * @test
     */
    public function testReadFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $this->json('GET', '/api/v1/favoriteRestaurants/'.$favoriteRestaurant->id);

        $this->assertApiResponse($favoriteRestaurant->toArray());
    }

    /**
     * @test
     */
    public function testUpdateFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $editedFavoriteRestaurant = $this->fakeFavoriteRestaurantData();

        $this->json('PUT', '/api/v1/favoriteRestaurants/'.$favoriteRestaurant->id, $editedFavoriteRestaurant);

        $this->assertApiResponse($editedFavoriteRestaurant);
    }

    /**
     * @test
     */
    public function testDeleteFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $this->json('DELETE', '/api/v1/favoriteRestaurants/'.$favoriteRestaurant->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/favoriteRestaurants/'.$favoriteRestaurant->id);

        $this->assertResponseStatus(404);
    }
}
