<?php

class ManufacturerController extends \BaseController {

	protected $layout = 'template';

	/**
     * Display a listing of the resource.
     *
     * @return Response
     */	

    public function index()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {
                $manufacturers = DB::select("SELECT id, title, phone, website FROM manufacturers WHERE seller_id = '$user->company'");
            }
            else
            {
                $manufacturers = DB::select("SELECT id, title, phone, website FROM manufacturers");
            }

            $this->layout->content = View::make('manufacturer.index', array(
                'manufacturers'   => $manufacturers,
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
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $user = Sentry::getUser();

            $sellers = DB::select("SELECT id, company FROM sellers");

            $this->layout->content = View::make('manufacturer.create', array(
                'user'  => $user,
                'sellers'   => $sellers,
                ));
        }
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
            try
            {
                $user = Sentry::getUser();

                if ($user->hasAccess('admin') != True)
                {
                    $seller  = $user->company;
                }

                else
                {
                    $seller  = Input::get('seller_id');
                }

                $manufacturer = new Manufacturer;
                $manufacturer->seller_id = $seller;
                $manufacturer->title = Input::get('title');
                $manufacturer->image = Input::get('image');
                $manufacturer->phone = Input::get('phone');
                $manufacturer->email = Input::get('email');
                $manufacturer->website = Input::get('website');
                $manufacturer->save();

                return Redirect::to('/manufacturers');
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
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $manufacturers = DB::select("SELECT * FROM manufacturers WHERE id = '$id'");
            $this->layout->content = View::make('manufacturer.show', array(
                'manufacturers'   => $manufacturers,
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
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $manufacturers = DB::select("SELECT * FROM manufacturers WHERE id = '$id'");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('manufacturer.edit', array(
                'manufacturers'   => $manufacturers,
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
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            try
            {
                $user = Sentry::getUser();

                if ($user->hasAccess('admin') != True)
                {
                    $seller  = $user->company;
                }

                else
                {
                    $seller  = Input::get('seller_id');
                }

                $manufacturer = Manufacturer::find($id);
                $manufacturer->seller_id = $seller;
                $manufacturer->title = Input::get('title');
                $manufacturer->image = Input::get('image');
                $manufacturer->phone = Input::get('phone');
                $manufacturer->email = Input::get('email');
                $manufacturer->website = Input::get('website');
                $manufacturer->save();

                return Redirect::to('/manufacturers/'.$id);
            }

            catch (\Exception $e)
            {
                echo "Failed : Creating the Seller";
            }
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
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }


}
