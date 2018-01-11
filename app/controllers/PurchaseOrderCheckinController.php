<?php

class PurchaseordercheckinController extends \BaseController {

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
            $purchaseorders = DB::select("SELECT purchase_orders.id AS po_id, sellers.company AS seller, suppliers.title AS supplier, status, products.id AS product_id FROM purchase_orders LEFT JOIN sellers ON (sellers.id = purchase_orders.seller_id) LEFT JOIN suppliers ON (suppliers.id = purchase_orders.supplier_id) LEFT JOIN products ON (products.aid = purchase_order_items.aid)");
            $this->layout->content = View::make('purchase.index', array(
                'purchaseorders'    => $purchaseorders,
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
            $products = DB::select("SELECT id, title, aid FROM products");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $suppliers = DB::select("SELECT id, title FROM suppliers");
            $this->layout->content = View::make('purchase.create', array(
                'sellers'   => $sellers,
                'suppliers'   => $suppliers,
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
                    $id = Input::get('po');
                    $item = Input::get('item');
                    $quantity = Input::get('quantity');
                    $date = Input::get('date');

                    $count = count($quantity);
                    
                    for($i=0;$i<$count;$i++) 
                    {

                        if(!empty($quantity[$i]) || !empty($date[$i]))
                        {
                            $checkin = new PurchaseOrderCheckin;
                            $checkin->poi_id = $item[$i];
                            $checkin->quantity = $quantity[$i];
                            $checkin->arrival_date = $date[$i];
                            $checkin->save();
                        }

                        else
                        {
                            continue;
                        }
                    }

                    return Redirect::to('/purchase-orders/'.$id);
            }

            catch (\Exception $e)
            {
                return "Failed : Creating the Purchase Orders";
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
            $purchaseorders = DB::select("SELECT purchase_orders.id as po_id, sellers.company as seller, suppliers.title as supplier, purchase_orders.status as po_status FROM purchase_orders LEFT JOIN sellers ON (sellers.id = purchase_orders.seller_id) LEFT JOIN suppliers ON (suppliers.id = purchase_orders.supplier_id) WHERE purchase_orders.id = '$id'");
            $items = DB::select("SELECT *, products.id AS product_id  FROM purchase_order_items LEFT JOIN products ON (products.aid = purchase_order_items.aid) WHERE po_id = '$id'");
            $this->layout->content = View::make('checkin.show', array(
                'purchaseorders'    => $purchaseorders,
                'items' => $items,
                'id'    => $id,
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
            $this->layout->content = View::make('purchase.index');
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
            $this->layout->content = View::make('');
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
