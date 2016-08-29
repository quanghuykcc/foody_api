<?php

use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RestaurantRepositoryTest extends TestCase
{
    use MakeRestaurantTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepo;

    public function setUp()
    {
        parent::setUp();
        $this->restaurantRepo = App::make(RestaurantRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRestaurant()
    {
        $restaurant = $this->fakeRestaurantData();
        $createdRestaurant = $this->restaurantRepo->create($restaurant);
        $createdRestaurant = $createdRestaurant->toArray();
        $this->assertArrayHasKey('id', $createdRestaurant);
        $this->assertNotNull($createdRestaurant['id'], 'Created Restaurant must have id specified');
        $this->assertNotNull(Restaurant::find($createdRestaurant['id']), 'Restaurant with given id must be in DB');
        $this->assertModelData($restaurant, $createdRestaurant);
    }

    /**
     * @test read
     */
    public function testReadRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $dbRestaurant = $this->restaurantRepo->find($restaurant->id);
        $dbRestaurant = $dbRestaurant->toArray();
        $this->assertModelData($restaurant->toArray(), $dbRestaurant);
    }

    /**
     * @test update
     */
    public function testUpdateRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $fakeRestaurant = $this->fakeRestaurantData();
        $updatedRestaurant = $this->restaurantRepo->update($fakeRestaurant, $restaurant->id);
        $this->assertModelData($fakeRestaurant, $updatedRestaurant->toArray());
        $dbRestaurant = $this->restaurantRepo->find($restaurant->id);
        $this->assertModelData($fakeRestaurant, $dbRestaurant->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRestaurant()
    {
        $restaurant = $this->makeRestaurant();
        $resp = $this->restaurantRepo->delete($restaurant->id);
        $this->assertTrue($resp);
        $this->assertNull(Restaurant::find($restaurant->id), 'Restaurant should not exist in DB');
    }
}
