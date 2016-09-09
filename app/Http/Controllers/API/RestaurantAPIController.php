<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRestaurantAPIRequest;
use App\Http\Requests\API\UpdateRestaurantAPIRequest;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Carbon\Carbon;
use App\Http\Criteria\FavoriteUserIdCriteria;

/**
 * Class RestaurantController
 * @package App\Http\Controllers\API
 */

class RestaurantAPIController extends InfyOmBaseController
{
    /** @var  RestaurantRepository */
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepo)
    {
        $this->restaurantRepository = $restaurantRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/restaurants",
     *      summary="Get a listing of the Restaurants.",
     *      tags={"Restaurant"},
     *      description="Get all Restaurants",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Restaurant")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->restaurantRepository->pushCriteria(new RequestCriteria($request));
        $this->restaurantRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->restaurantRepository->pushCriteria(new CategoryIdCriteria($request));
        $this->restaurantRepository->pushCriteria(new LastSyncTimestampCriteria($request));   
        $this->restaurantRepository->pushCriteria(new FavoriteUserIdCriteria($request));

        $restaurants = $this->restaurantRepository->with('category')->with('comments')->all();

        $last_sync_timestamp = Carbon::now()->toDateTimeString();

        return $this->sendResponse($restaurants->toArray(), 'Restaurants retrieved successfully', $last_sync_timestamp);
    }

    /**
     * @param CreateRestaurantAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/restaurants",
     *      summary="Store a newly created Restaurant in storage",
     *      tags={"Restaurant"},
     *      description="Store Restaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Restaurant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Restaurant")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Restaurant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRestaurantAPIRequest $request)
    {
        $input = $request->all();

        $restaurants = $this->restaurantRepository->create($input);

        return $this->sendResponse($restaurants->toArray(), 'Restaurant saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/restaurants/{id}",
     *      summary="Display the specified Restaurant",
     *      tags={"Restaurant"},
     *      description="Get Restaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Restaurant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Restaurant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->restaurantRepository->find($id);

        if (empty($restaurant)) {
            return Response::json(ResponseUtil::makeError('Restaurant not found'), 404);
        }

        return $this->sendResponse($restaurant->toArray(), 'Restaurant retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRestaurantAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/restaurants/{id}",
     *      summary="Update the specified Restaurant in storage",
     *      tags={"Restaurant"},
     *      description="Update Restaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Restaurant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Restaurant that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Restaurant")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Restaurant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRestaurantAPIRequest $request)
    {
        $input = $request->all();

        /** @var Restaurant $restaurant */
        $restaurant = $this->restaurantRepository->find($id);

        if (empty($restaurant)) {
            return Response::json(ResponseUtil::makeError('Restaurant not found'), 404);
        }

        $restaurant = $this->restaurantRepository->update($input, $id);

        return $this->sendResponse($restaurant->toArray(), 'Restaurant updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/restaurants/{id}",
     *      summary="Remove the specified Restaurant from storage",
     *      tags={"Restaurant"},
     *      description="Delete Restaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Restaurant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->restaurantRepository->find($id);

        if (empty($restaurant)) {
            return Response::json(ResponseUtil::makeError('Restaurant not found'), 404);
        }

        $restaurant->delete();

        return $this->sendResponse($id, 'Restaurant deleted successfully');
    }
}
