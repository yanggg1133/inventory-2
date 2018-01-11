<?php

class virtualproductController extends \BaseController {

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

            $virtualproducts = DB::select("SELECT id, asin, title FROM virtual_products");

            $this->layout->content = View::make('virtual.index', array(
                'virtualproducts'    => $virtualproducts,
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

            if ($user->hasAccess('admin') != True)
            {
                $seller  = $user->company;
            }

            else
            {
                $seller  = Input::get('seller_id');
            }

            $products = DB::select("SELECT id, title, aid FROM products");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('virtual.create', array(
                'user'  => $user,
                'sellers'   => $sellers,
                'products'   => $products,
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
                
                    $virtualproduct = new VirtualProduct;
                    $virtualproduct->seller_id = Input::get('seller_id');
                    $virtualproduct->asin = Input::get('asin');
                    $virtualproduct->title = Input::get('title');
                    $virtualproduct->save();

                    $vp_id = $virtualproduct->id;

                    $aid = Input::get('aid');
                    $count = count($aid);
                    
                    for($i=0;$i<$count;$i++) {
                        $virtualproductitem = new VirtualProductItem;
                        $virtualproductitem->vp_id = $vp_id;
                        $virtualproductitem->aid = $aid[$i];
                        $virtualproductitem->save();
                    }

                    return Redirect::to('/virtual-products');
            }

            catch (\Exception $e)
            {
                return "Failed : Creating the Virtual Product";
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
            $virtual_products= DB::select("SELECT virtual_products.*, sellers.company as seller FROM virtual_products LEFT JOIN sellers ON (sellers.id = virtual_products.seller_id) WHERE virtual_products.id = $id");
            $products = DB::select("SELECT products.aid as aid, products.aid as sku, products.title as title FROM products LEFT JOIN virtual_product_items ON (virtual_product_items.aid = products.aid) WHERE virtual_product_items.vp_id = $id");

        }
        
        $this->layout->content = View::make('virtual.show', array(
            'virtual_products' => $virtual_products,
            'products' => $products,
            ));

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

            $user = Sentry::getUser();
            $virtual_products= DB::select("SELECT virtual_products.*, sellers.company as seller FROM virtual_products LEFT JOIN sellers ON (sellers.id = virtual_products.seller_id) WHERE virtual_products.id = $id");
            $items = DB::select("SELECT virtual_product_items.id as item_id, products.aid as aid, products.aid as sku, products.title as title FROM products LEFT JOIN virtual_product_items ON (virtual_product_items.aid = products.aid) WHERE virtual_product_items.vp_id = $id");
            $products = DB::select("SELECT id, title, aid FROM products");
            $sellers = DB::select("SELECT id, company FROM sellers");

            $this->layout->content = View::make('virtual.edit', array(
                'user' => $user,
                'sellers'   => $sellers,
                'products'   => $products,
                'virtual_products' => $virtual_products,
                'items' => $items
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
                
                    $virtualproduct = VirtualProduct::find($id);
                    $virtualproduct->seller_id = Input::get('seller_id');
                    $virtualproduct->asin = Input::get('asin');
                    $virtualproduct->title = Input::get('title');
                    $virtualproduct->save();

                    $vp_id = $virtualproduct->id;

                    $aid = Input::get('aid');
                    $item_id = Input::get('item_id');
                    $count = count($aid);
                    
                    for($i=0;$i<$count;$i++) {
                        $virtualproductitem = VirtualProductItem::find($item_id[$i]);
                        $virtualproductitem->aid = $aid[$i];
                        $virtualproductitem->save();
                    }

                    return Redirect::to('/virtual-products');
            }

            catch (\Exception $e)
            {
                return "Failed : Creating the Virtual Product";
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

public function invoice($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }

        else
        {
        }
    }

}
