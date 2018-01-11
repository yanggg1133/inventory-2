<?php

class UserApiProfileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {

            	if (Input::get('provider') == 'amazon')
            	{
            		$api = new UserApiProfile;
            		$api->seller_id = Input::get('seller');
            		$api->provider = 'amazon';
                    $api->api_cred1 = Input::get('amazon-merchant-id');
                    $api->api_cred2 = Input::get('amazon-marketplace-id');
                    $api->api_cred3 = Input::get('amazon-aws-id');
                    $api->api_cred4 = Input::get('amazon-secret-key');
                    $api->save();
            	}

            	if (Input::get('provider') == 'ebay')
            	{
            		$api = new UserApiProfile;
            		$api->seller_id = Input::get('seller');
            		$api->provider = 'ebay';
            		$api->api_cred1 = Input::get('cs-user');
                    $api->api_cred1 = Input::get('ebay-token');
                    $api->save();
            	}

            	if (Input::get('provider') == 'cs-cart')
            	{
            		$api = new UserApiProfile;
            		$api->seller_id = Input::get('seller');
            		$api->provider = 'cs-cart';
                    $api->api_cred1 = Input::get('cs-user');
                    $api->api_cred2 = Input::get('cs-token');
                    $api->save();
            	}

            	return  Redirect::to('/sellers/'.Input::get('seller'));
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
