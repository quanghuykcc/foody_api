<?php

use App\Models\FavoriteRestaurant;
use App\Repositories\FavoriteRestaurantRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteRestaurantRepositoryTest extends TestCase
{
    use MakeFavoriteRestaurantTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var FavoriteRestaurantRepository
     */
    protected $favoriteRestaurantRepo;

    public function setUp()
    {
        parent::setUp();
        $this->favoriteRestaurantRepo = App::make(FavoriteRestaurantRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->fakeFavoriteRestaurantData();
        $createdFavoriteRestaurant = $this->favoriteRestaurantRepo->create($favoriteRestaurant);
        $createdFavoriteRestaurant = $createdFavoriteRestaurant->toArray();
        $this->assertArrayHasKey('id', $createdFavoriteRestaurant);
        $this->assertNotNull($createdFavoriteRestaurant['id'], 'Created FavoriteRestaurant must have id specified');
        $this->assertNotNull(FavoriteRestaurant::find($createdFavoriteRestaurant['id']), 'FavoriteRestaurant with given id must be in DB');
        $this->assertModelData($favoriteRestaurant, $createdFavoriteRestaurant);
    }

    /**
     * @test read
     */
    public function testReadFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $dbFavoriteRestaurant = $this->favoriteRestaurantRepo->find($favoriteRestaurant->id);
        $dbFavoriteRestaurant = $dbFavoriteRestaurant->toArray();
        $this->assertModelData($favoriteRestaurant->toArray(), $dbFavoriteRestaurant);
    }

    /**
     * @test update
     */
    public function testUpdateFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $fakeFavoriteRestaurant = $this->fakeFavoriteRestaurantData();
        $updatedFavoriteRestaurant = $this->favoriteRestaurantRepo->update($fakeFavoriteRestaurant, $favoriteRestaurant->id);
        $this->assertModelData($fakeFavoriteRestaurant, $updatedFavoriteRestaurant->toArray());
        $dbFavoriteRestaurant = $this->favoriteRestaurantRepo->find($favoriteRestaurant->id);
        $this->assertModelData($fakeFavoriteRestaurant, $dbFavoriteRestaurant->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteFavoriteRestaurant()
    {
        $favoriteRestaurant = $this->makeFavoriteRestaurant();
        $resp = $this->favoriteRestaurantRepo->delete($favoriteRestaurant->id);
        $this->assertTrue($resp);
        $this->assertNull(FavoriteRestaurant::find($favoriteRestaurant->id), 'FavoriteRestaurant should not exist in DB');
    }
}
