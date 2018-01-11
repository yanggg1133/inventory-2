<?php

class SalesorderController extends \BaseController {

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
            $orders = DB::select("SELECT id, order_id, purchase_date, buyer_name, email, status, purchase_source FROM sales_orders WHERE status != 'canceled' AND status != 'returned' AND YEAR(purchase_date) = YEAR(CURDATE())");
            $this->layout->content = View::make('sales.index', array(
                'orders' => $orders,
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
            $this->layout->content = View::make('');
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
            $this->layout->content = View::make('');
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
            $orders = DB::select("SELECT sales_orders . * , shipments.main_tracking FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE sales_orders.order_id = '$id'");

            foreach ($orders as $order) {
                $order_id = $order->id;
                $shipment = $order->main_tracking;
            }

            $packages = DB::select("SELECT shipment_packages.tracking_num , shipment_packages.created_at FROM shipment_packages LEFT JOIN shipments ON (shipments.id = shipment_packages.ship_id) LEFT JOIN sales_orders ON (sales_orders.id = shipments.so_id) WHERE sales_orders.order_id ='$id'");

            $items = DB::select("SELECT products.title as product, sales_order_items.quantity as quantity, sales_order_items.cost_per_item as cost, sales_order_items.total as total FROM sales_order_items LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_order_items.so_id = '$order_id'");

            $this->layout->content = View::make('sales.show', array(
                'shipment' => $shipment,
                'order_id' => $order_id,
                'orders' => $orders,
                'items' => $items,
                'packages' => $packages
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
            $this->layout->content = View::make('sales.index');
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
            $shipmentpack = SalesOrder::find($id);
            $shipmentpack->status = 'canceled';
            $shipmentpack->save();
            return Redirect::to('/sales-orders');
        }
    }

    public function changeStatus($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $shipmentpack = SalesOrder::find($id);
            $shipmentpack->status = Input::get('status');;
            $shipmentpack->save();

            $orders = DB::select("SELECT order_id FROM sales_orders WHERE id = $id");
            $order = json_decode(json_encode($orders), true);

            return Redirect::to('/sales-orders/'.$order[0]["order_id"]);
        }
    }


}
