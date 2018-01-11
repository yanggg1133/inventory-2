<?php

class PurchaseorderitemController extends \BaseController {

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
            $purchaseorders = DB::select("SELECT purchase_orders.id as po_id, sellers.company as seller, suppliers.title as supplier, status FROM purchase_orders LEFT JOIN sellers ON (sellers.id = purchase_orders.seller_id) LEFT JOIN suppliers ON (suppliers.id = purchase_orders.supplier_id)");
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
                    $purchaseorder = new PurchaseOrder;
                    $purchaseorder->seller_id = Input::get('seller_id');
                    $purchaseorder->supplier_id = Input::get('supplier_id');
                    $purchaseorder->status = 'processing';
                    $purchaseorder->save();

                    $po_id = $purchaseorder->id;

                    $aid = Input::get('aid');
                    $quantity = Input::get('quantity');
                    $cost = Input::get('cost_per_item');
                    $eta = Input::get('estimated_arrival');
                    $tracking = Input::get('tracking');

                    $count = count($aid);
                    
                    for($i=0;$i<$count;$i++) {
                        $purchaseorderitem = new PurchaseOrderItem;
                        $purchaseorderitem->po_id = $po_id;
                        $purchaseorderitem->aid = $aid[$i];
                        $purchaseorderitem->quantity = $quantity[$i];
                        $purchaseorderitem->cost_per_item = $cost[$i];
                        $purchaseorderitem->estimated_arrival = $eta[$i];
                        $purchaseorderitem->tracking = $tracking[$i];
                        $purchaseorderitem->status = 'processing';
                        $purchaseorderitem->save();
                    }

                    return Redirect::to('/purchase-orders');
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
            $items = DB::select("SELECT * FROM purchase_order_items WHERE po_id = '$id'");
            $this->layout->content = View::make('purchase.show', array(
                'purchaseorders'    => $purchaseorders,
                'items' => $items,
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
            try
            {
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->seller_id = Input::get('seller_id');
                    $purchaseorder->supplier_id = Input::get('supplier_id');
                    $purchaseorder->status = 'processing';
                    $purchaseorder->save();

                    $po_id = $purchaseorder->id;

                    $aid = Input::get('aid');
                    $quantity = Input::get('quantity');
                    $cost = Input::get('cost_per_item');
                    $eta = Input::get('estimated_arrival');
                    $tracking = Input::get('tracking');

                    $count = count($aid);
                    
                    for($i=0;$i<$count;$i++) {
                        $purchaseorderitem = new PurchaseOrderItem;
                        $purchaseorderitem->po_id = $po_id;
                        $purchaseorderitem->aid = $aid[$i];
                        $purchaseorderitem->quantity = $quantity[$i];
                        $purchaseorderitem->cost_per_item = $cost[$i];
                        $purchaseorderitem->estimated_arrival = $eta[$i];
                        $purchaseorderitem->tracking = $tracking[$i];
                        $purchaseorderitem->status = 'processing';
                        $purchaseorderitem->save();
                    }

                    return Redirect::to('/purchase-orders');
            }

            catch (\Exception $e)
            {
                return "Failed : Creating the Purchase Orders";
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
