<?php

class SellerController extends \BaseController {

	protected $layout = 'template';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
        	$sellers = DB::select("SELECT id, company, prefixer, website FROM sellers");
            $this->layout->content = View::make('seller.index', array(
            	'sellers' => $sellers,
            	));
        }
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {

            $this->layout->content = View::make('seller.create');
        }
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
        	try
        	{
	            $seller = new Seller;
	            $seller->company = Input::get('company');
	            $seller->prefixer = Input::get('prefixer');
	            $seller->phone = Input::get('phone');
	            $seller->email = Input::get('email');
	            $seller->website = Input::get('website');
	            $seller->save();

	            return Redirect::to('/sellers');
        	}

        	catch (\Exception $e)
        	{
        		echo "Failed : Creating the Seller";
        	}

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
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $sellers = DB::select("SELECT id, company, prefixer, phone, website FROM sellers WHERE id = '$id'");
            $ebay = DB::select("SELECT api_cred1 FROM user_api_profiles WHERE seller_id = '$id' AND provider = 'ebay'");
            $amazon = DB::select("SELECT api_cred1, api_cred2, api_cred3, api_cred4 FROM user_api_profiles WHERE seller_id = '$id' AND provider = 'amazon'");
            $cscart = DB::select("SELECT api_cred1, api_cred2 FROM user_api_profiles WHERE seller_id = '$id' AND provider = 'cs-cart'");
            $this->layout->content = View::make('seller.show', array(
            	'sellers' => $sellers,
            	'ebay' => $ebay,
            	'amazon' => $amazon,
            	'cscart' => $cscart,
            	));
        }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $sellers = DB::select("SELECT id, company, prefixer, phone, email, website FROM sellers WHERE id = '$id'");
            $this->layout->content = View::make('seller.edit', array(
            	'sellers' => $sellers,
                'id'    => $id,
            	));
        }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('users.index');
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('users.index');
        }
	}


}
