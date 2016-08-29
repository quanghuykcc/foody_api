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
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use Validator;

class AuthenticateAPIController extends InfyOmBaseController
{

	public function postSignIn(Request $request) {

			$credentials = $request->only('email', 'password');

	        try {
	            // verify the credentials and create a token for the user
	            if (! $token = JWTAuth::attempt($credentials)) {
	            	return Response::json(ResponseUtil::makeError('invalid_credentials'));
	            }
	        } catch (JWTException $e) {
	            // something went wrong
	        	return Response::json(ResponseUtil::makeError('could_not_create_token'));
	        }

	        $loggedInUser = JWTAuth::toUser($token);


	        $arrLoggedInUser = $loggedInUser->toArray();
	        $arrLoggedInUser['remember_token'] = $token;

	        // if no errors are encountered we can return a JWT
	        return $this->sendResponse($arrLoggedInUser, 'Logged in successfully');
	}

	public function postSignUp(Request $request) {

		$credentials = $request->only('email', 'password', 'name');

		$validator = Validator::make($credentials, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return Response::json(ResponseUtil::makeError('Wrong input fields'));
        }

		try {
		   	$user = User::create([
	            'name' => $credentials['name'],
	            'email' => $credentials['email'],
	            'password' => bcrypt($credentials['password']),
        	]);
		} catch (Exception $e) {

		   return Response::json(ResponseUtil::makeError('User already exists'))	;
		}

		return $this->sendResponse(true, 'User created successfully');
	}
}
