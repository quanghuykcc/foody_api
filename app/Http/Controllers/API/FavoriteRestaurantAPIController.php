<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFavoriteRestaurantAPIRequest;
use App\Http\Requests\API\UpdateFavoriteRestaurantAPIRequest;
use App\Models\FavoriteRestaurant;
use App\Repositories\FavoriteRestaurantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Http\Criteria\UserIdCriteria;
use Carbon\Carbon;

/**
 * Class FavoriteRestaurantController
 * @package App\Http\Controllers\API
 */

class FavoriteRestaurantAPIController extends InfyOmBaseController
{
    /** @var  FavoriteRestaurantRepository */
    private $favoriteRestaurantRepository;

    public function __construct(FavoriteRestaurantRepository $favoriteRestaurantRepo)
    {
        $this->favoriteRestaurantRepository = $favoriteRestaurantRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/favoriteRestaurants",
     *      summary="Get a listing of the FavoriteRestaurants.",
     *      tags={"FavoriteRestaurant"},
     *      description="Get all FavoriteRestaurants",
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
     *                  @SWG\Items(ref="#/definitions/FavoriteRestaurant")
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
        $this->favoriteRestaurantRepository->pushCriteria(new RequestCriteria($request));
        $this->favoriteRestaurantRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->favoriteRestaurantRepository->pushCriteria(new UserIdCriteria($request));
        $this->favoriteRestaurantRepository->pushCriteria(new LastSyncTimestampCriteria($request));

        $favoriteRestaurants = $this->favoriteRestaurantRepository->all();

        $last_sync_timestamp = Carbon::now()->toDateTimeString();

        return $this->sendResponse($favoriteRestaurants->toArray(), 'FavoriteRestaurants retrieved successfully', $last_sync_timestamp);
    }

    /**
     * @param CreateFavoriteRestaurantAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/favoriteRestaurants",
     *      summary="Store a newly created FavoriteRestaurant in storage",
     *      tags={"FavoriteRestaurant"},
     *      description="Store FavoriteRestaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FavoriteRestaurant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FavoriteRestaurant")
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
     *                  ref="#/definitions/FavoriteRestaurant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFavoriteRestaurantAPIRequest $request)
    {
        $input = $request->all();

        $favoriteRestaurants = $this->favoriteRestaurantRepository->create($input);

        return $this->sendResponse($favoriteRestaurants->toArray(), 'FavoriteRestaurant saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/favoriteRestaurants/{id}",
     *      summary="Display the specified FavoriteRestaurant",
     *      tags={"FavoriteRestaurant"},
     *      description="Get FavoriteRestaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FavoriteRestaurant",
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
     *                  ref="#/definitions/FavoriteRestaurant"
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
        /** @var FavoriteRestaurant $favoriteRestaurant */
        $favoriteRestaurant = $this->favoriteRestaurantRepository->find($id);

        if (empty($favoriteRestaurant)) {
            return Response::json(ResponseUtil::makeError('FavoriteRestaurant not found'), 404);
        }

        return $this->sendResponse($favoriteRestaurant->toArray(), 'FavoriteRestaurant retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFavoriteRestaurantAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/favoriteRestaurants/{id}",
     *      summary="Update the specified FavoriteRestaurant in storage",
     *      tags={"FavoriteRestaurant"},
     *      description="Update FavoriteRestaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FavoriteRestaurant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FavoriteRestaurant that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FavoriteRestaurant")
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
     *                  ref="#/definitions/FavoriteRestaurant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFavoriteRestaurantAPIRequest $request)
    {
        $input = $request->all();

        /** @var FavoriteRestaurant $favoriteRestaurant */
        $favoriteRestaurant = $this->favoriteRestaurantRepository->find($id);

        if (empty($favoriteRestaurant)) {
            return Response::json(ResponseUtil::makeError('FavoriteRestaurant not found'), 404);
        }

        $favoriteRestaurant = $this->favoriteRestaurantRepository->update($input, $id);

        return $this->sendResponse($favoriteRestaurant->toArray(), 'FavoriteRestaurant updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/favoriteRestaurants/{id}",
     *      summary="Remove the specified FavoriteRestaurant from storage",
     *      tags={"FavoriteRestaurant"},
     *      description="Delete FavoriteRestaurant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FavoriteRestaurant",
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
        /** @var FavoriteRestaurant $favoriteRestaurant */
        $favoriteRestaurant = $this->favoriteRestaurantRepository->find($id);

        if (empty($favoriteRestaurant)) {
            return Response::json(ResponseUtil::makeError('FavoriteRestaurant not found'), 404);
        }

        $favoriteRestaurant->delete();

        return $this->sendResponse($id, 'FavoriteRestaurant deleted successfully');
    }
}
