<?php

class SupplierController extends \BaseController {

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
                $suppliers = DB::select("SELECT id, title, rep, phone FROM suppliers WHERE seller_id = '$user->company'");
            }

            else
            {
                $suppliers = DB::select("SELECT id, title, rep, phone FROM suppliers");
            }

            $this->layout->content = View::make('supplier.index', array(
                    'suppliers' => $suppliers,
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

            $this->layout->content = View::make('supplier.create', array(
                'user' => $user,
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

                $supplier = new Supplier;
                $supplier->seller_id = $seller;
                $supplier->title = Input::get('title');
                $supplier->image = Input::get('image');
                $supplier->rep = Input::get('rep');
                $supplier->phone = Input::get('phone');
                $supplier->email = Input::get('email');
                $supplier->website = Input::get('website');
                $supplier->address1 = Input::get('address1');
                $supplier->address2 = Input::get('address2');
                $supplier->city = Input::get('city');
                $supplier->state = Input::get('state');
                $supplier->zip = Input::get('zip');
                $supplier->save();

                return Redirect::to('/suppliers');
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
            $suppliers = DB::select("SELECT * FROM suppliers WHERE id = '$id'");

            $this->layout->content = View::make('supplier.show', array(
                'suppliers'   => $suppliers,
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
            $suppliers = DB::select("SELECT * FROM suppliers WHERE id = '$id'");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('supplier.edit', array(
                'suppliers'   => $suppliers,
                'sellers'   => $sellers,
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

                $supplier = Supplier::find($id);
                $supplier->seller_id = $seller;
                $supplier->title = Input::get('title');
                $supplier->image = Input::get('image');
                $supplier->rep = Input::get('rep');
                $supplier->phone = Input::get('phone');
                $supplier->email = Input::get('email');
                $supplier->website = Input::get('website');
                $supplier->address1 = Input::get('address1');
                $supplier->address2 = Input::get('address2');
                $supplier->city = Input::get('city');
                $supplier->state = Input::get('state');
                $supplier->zip = Input::get('zip');
                $supplier->save();

                return Redirect::to('/suppliers/'.$id);
            }

            catch (\Exception $e)
            {
                echo "Failed : Creating the Supplier";
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
