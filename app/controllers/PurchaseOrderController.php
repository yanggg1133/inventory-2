<?php

class PurchaseorderController extends \BaseController {

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
                $purchaseorders = DB::select("SELECT purchase_orders.id as po_id, sellers.company as seller, suppliers.title as supplier, status FROM purchase_orders LEFT JOIN sellers ON (sellers.id = purchase_orders.seller_id) LEFT JOIN suppliers ON (suppliers.id = purchase_orders.supplier_id) WHERE purchase_orders.seller_id = '$user->company'");
            }

            else
            {
                $purchaseorders = DB::select("SELECT purchase_orders.id as po_id, sellers.company as seller, suppliers.title as supplier, status FROM purchase_orders LEFT JOIN sellers ON (sellers.id = purchase_orders.seller_id) LEFT JOIN suppliers ON (suppliers.id = purchase_orders.supplier_id)");
            }

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
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {
                $seller  = $user->company;
            }

            else
            {
                $seller  = Input::get('seller_id');
            }

            $products = DB::select("SELECT id, sku, title, aid FROM products");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $suppliers = DB::select("SELECT id, title FROM suppliers");
            $this->layout->content = View::make('purchase.make', array(
                'user'  => $user,
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
                $user = Sentry::getUser();

                if ($user->hasAccess('admin') != True)
                {
                    $seller  = $user->company;
                }

                else
                {
                    $seller  = Input::get('seller_id');
                }
                
                    $purchaseorder = new PurchaseOrder;
                    $purchaseorder->seller_id = $seller;
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
            //$items = DB::select("SELECT * , IF( SUM( purchase_order_items.quantity ) IS NOT NULL , SUM( purchase_order_items.quantity ) , 0 ) AS quantity, purchase_order_items.aid AS aid, IF( SUM( purchase_order_checkins.quantity ) IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS received_total, products.id AS product_id FROM purchase_order_items LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) LEFT JOIN products ON (products.aid = purchase_order_items.aid) AND purchase_order_checkins.quantity IS NOT NULL WHERE purchase_order_items.po_id = '$id'");
            $purchase_counts = DB::select("SELECT * , IF( SUM( purchase_order_items.quantity ) IS NOT NULL , SUM( purchase_order_items.quantity ) , 0 ) AS ordered, purchase_order_items.aid AS aid, IF( SUM( purchase_order_checkins.quantity ) IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS received, products.id AS product_id FROM purchase_order_items LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) LEFT JOIN products ON (products.aid = purchase_order_items.aid) AND purchase_order_checkins.quantity IS NOT NULL WHERE purchase_order_items.po_id = '$id'");
            $ordered = DB::select("SELECT IF( SUM( purchase_order_items.quantity ) IS NOT NULL , SUM( purchase_order_items.quantity ) , 0 ) AS quantity FROM purchase_order_items WHERE purchase_order_items.po_id = '$id'");
            $received = DB::select("SELECT IF( SUM( purchase_order_checkins.quantity ) IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS quantity FROM purchase_order_items LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) LEFT JOIN products ON (products.aid = purchase_order_items.aid) AND purchase_order_checkins.quantity IS NOT NULL WHERE purchase_order_items.po_id = '$id'");
            $items = DB::select("SELECT *, products.title as product, purchase_order_items.id as item_id, purchase_order_items.quantity as ordered_quantity, IF( SUM( purchase_order_checkins.quantity ) IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS received_quantity, purchase_order_items.aid AS aid, products.id AS product_id FROM purchase_order_items LEFT JOIN products ON (products.aid = purchase_order_items.aid) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id) WHERE purchase_order_items.po_id = $id GROUP BY purchase_order_items.id");
            $invoices = DB::select("SELECT image, created_at FROM invoices WHERE po_id = $id");

            $received = json_decode(json_encode($received), true);
            $ordered = json_decode(json_encode($ordered), true);

            $received = $received[0]["quantity"];
            $ordered = $ordered[0]["quantity"];

                if (0 < $ordered && $ordered > $received)
                {
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->status = 'Partial';
                    $purchaseorder->save();
                }

                if ($ordered == $received)
                {
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->status = 'Complete';
                    $purchaseorder->save();
                }

                if ($ordered < $received)
                {
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->status = 'Over';
                    $purchaseorder->save();
                }

                if ($ordered < $received)
                {
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->status = 'Over';
                    $purchaseorder->save();
                }

            foreach ($purchaseorders as $purchaseorder) {

                if ($purchaseorder->po_status != 'Complete')
                {
                    foreach ($items as $item) {

                        if (0 < $item->ordered_quantity && $item->ordered_quantity > $item->received_quantity)
                        {
                            $purchaseorder = PurchaseOrderItem::find($item->item_id);
                            $purchaseorder->status = 'Partial';
                            $purchaseorder->save();
                        }

                        if ($item->ordered_quantity == $item->received_quantity)
                        {
                            $purchaseorder = PurchaseOrderItem::find($item->item_id);
                            $purchaseorder->status = 'Complete';
                            $purchaseorder->save();
                        }

                        if ($item->ordered_quantity < $item->received_quantity)
                        {
                            $purchaseorder = PurchaseOrderItem::find($item->item_id);
                            $purchaseorder->status = 'Over';
                            $purchaseorder->save();
                        }
                    }

                }

            }


            $this->layout->content = View::make('purchase.show', array(
                'purchaseorders'    => $purchaseorders,
                'items' => $items,
                'purchase_counts' => $purchase_counts,
                'received' => $received,
                'ordered' => $ordered,
                'invoices' => $invoices,
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
            $purchaseorders = DB::select("SELECT * FROM purchase_orders WHERE id = '$id'");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $suppliers = DB::select("SELECT id, title FROM suppliers");
            $products = DB::select("SELECT id, title, aid FROM products");
            $items = DB::select("SELECT * FROM purchase_order_items WHERE po_id = '$id'");
            $this->layout->content = View::make('purchase.edit', array(
                'purchaseorders'    => $purchaseorders,
                'sellers'   => $sellers,
                'suppliers'   => $suppliers,
                'products'   => $products,
                'items' => $items,
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
                
                    $purchaseorder = PurchaseOrder::find($id);
                    $purchaseorder->seller_id = $seller;
                    $purchaseorder->supplier_id = Input::get('supplier_id');
                    $purchaseorder->status = 'processing';
                    $purchaseorder->save();

                    return Redirect::to('/purchase-orders/'.$id);
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

    public function removeItem($id)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $purchaseorder = PurchaseOrderItem::find($id);
            $purchaseorder->delete();


            return Redirect::to('/purchase-orders/');
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
            $purchaseorder = PurchaseOrder::find($id);
            $purchaseorder->status = Input::get('status');;
            $purchaseorder->save();

            return Redirect::to('/purchase-orders/');
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
                $invoice = new Invoice;
                $invoice->po_id = $id;

                if ($_FILES["image"]['size'] > 0) {
                    $newfilename = date("YmdHis").str_random(8).'.pdf';
                    $destinationPath = 'upload/invoices/'.$id.'/';
                    Input::file('image')->move($destinationPath, $newfilename);
                    $invoice->image = $newfilename;
                }

                $invoice->save();

                return Redirect::to('/purchase-orders/'.$id);
        }
    }

    public function pdf($id)
    {
        $pos = DB::select("SELECT created_at as date FROM purchase_orders WHERE id = $id");

        foreach ($pos as $po) {
            $po_date = $po->date;
        }

        $count = 0;

        $items = DB::select("SELECT products.title as title,  purchase_order_items.quantity as quantity FROM purchase_order_items LEFT JOIN products ON (products.aid = purchase_order_items.aid) WHERE po_id = $id");
        
        $html = '<div style="width:70%; margin: 0 auto;">
        <img src="assets/logo.png" width="450" style="margin: 25px 0;" />
        <table width="100%" style="margin: 20px 0; border-collapse: collapse;">
              <tr style="border-bottom: 1px solid #000;">
                <td style="text-align: left; padding: 5px; border: 1px solid #000;"><strong>PO# '.$id.'</strong></td>
                <td style="text-align: right; padding: 5px; border: 1px solid #000;"><strong>DATE :'.date("m-d-Y",strtotime($po_date)).'</strong></td>
              </tr>
        </table>
        <table width="100%" style="margin: 20px 0;">

              <tr style="border-bottom: 1px solid #000;">
                <td style="padding: 10px 0;"><strong>Product</strong></td>
                <td style="text-align: center; padding: 10px 0;"><strong>Order</strong></td>
              </tr>';
        foreach ($items as $item) {
            $html .= '<tr>
                <td style="padding: 10px 0; border-top: 1px dashed #000;">'.$item->title.'</td>
                <td style="text-align: center; padding: 10px 0; border-top: 1px dashed #000;">'.$item->quantity.'</td>
              </tr>';

              $count += $item->quantity;
        }

        $html .= '</table>
        <hr>
        <table width="100%" style="margin: 20px 0;">

              <tr class="row">
                <td width="75%"> </td>
                <td wiidth="25%" style="padding: 10px; border: 1px solid #000;"><strong>Total : '. $count .'</strong></td>
              </tr> 

        </table>

        <table width="160" style="padding: 0 10px; border: 1px solid #000;">
            <tr>
                <td><strong>Delivery Location:</strong></td>
            </tr>
            <tr>
                <td><strong>8650 S Pleasant Grove RD</strong></td>
            </tr>
            <tr>
                <td><strong>Inverness, FL 34452</strong></td>
            </tr>
        </table>
        </div>';


        $pdf = App::make('dompdf'); //Note: in 0.6.x this will be 'dompdf.wrapper'
        $pdf->loadHTML($html);
        return $pdf->stream();

    }

}
