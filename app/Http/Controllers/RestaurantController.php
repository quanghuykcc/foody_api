<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Repositories\RestaurantRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RestaurantController extends InfyOmBaseController
{
    /** @var  RestaurantRepository */
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepo)
    {
        $this->restaurantRepository = $restaurantRepo;
    }

    /**
     * Display a listing of the Restaurant.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->restaurantRepository->pushCriteria(new RequestCriteria($request));
        $restaurants = $this->restaurantRepository->all();

        return view('restaurants.index')
            ->with('restaurants', $restaurants);
    }

    /**
     * Show the form for creating a new Restaurant.
     *
     * @return Response
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created Restaurant in storage.
     *
     * @param CreateRestaurantRequest $request
     *
     * @return Response
     */
    public function store(CreateRestaurantRequest $request)
    {
        $input = $request->all();

        $restaurant = $this->restaurantRepository->create($input);

        Flash::success('Restaurant saved successfully.');

        return redirect(route('restaurants.index'));
    }

    /**
     * Display the specified Restaurant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error('Restaurant not found');

            return redirect(route('restaurants.index'));
        }

        return view('restaurants.show')->with('restaurant', $restaurant);
    }

    /**
     * Show the form for editing the specified Restaurant.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error('Restaurant not found');

            return redirect(route('restaurants.index'));
        }

        return view('restaurants.edit')->with('restaurant', $restaurant);
    }

    /**
     * Update the specified Restaurant in storage.
     *
     * @param  int              $id
     * @param UpdateRestaurantRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRestaurantRequest $request)
    {
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error('Restaurant not found');

            return redirect(route('restaurants.index'));
        }

        $restaurant = $this->restaurantRepository->update($request->all(), $id);

        Flash::success('Restaurant updated successfully.');

        return redirect(route('restaurants.index'));
    }

    /**
     * Remove the specified Restaurant from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error('Restaurant not found');

            return redirect(route('restaurants.index'));
        }

        $this->restaurantRepository->delete($id);

        Flash::success('Restaurant deleted successfully.');

        return redirect(route('restaurants.index'));
    }
}
