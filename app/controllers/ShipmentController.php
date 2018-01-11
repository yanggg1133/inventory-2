<?php

class ShipmentController extends \BaseController {


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $prints = DB::select("SELECT distinct shipment_packages.tracking_num , sales_order_items.aid as sku,  shipment_packages.created_at, sales_orders.buyer_name as name FROM shipment_packages LEFT JOIN shipments ON (shipments.id = shipment_packages.ship_id) LEFT JOIN sales_orders ON (sales_orders.id = shipments.so_id) LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE shipment_packages.scanned = 0");
        return View::make('shipments.index', array(
                'prints'   => $prints,
                ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        include app_path()."/controllers/libs/shipinfo.php";

        $pendingSales = DB::select("SELECT id, buyer_name as name, ship_address1 as address, ship_address2 as address2, ship_city as city, ship_state as state, ship_zip as zip, ship_phone as phone  FROM sales_orders WHERE status = 'pending'");


        foreach ($pendingSales as $sale) {

           $qty = 0;
           $ship_qty = 0;
           $convert = new ShipInfo();
           $abv = $convert->stateAbbrev($sale->state);
           $shipment = new \RocketShipIt\Shipment('UPS');

            $shipment->setParameter('toCompany', $sale->name);
            $shipment->setParameter('toPhone', $sale->phone);
            $shipment->setParameter('toAddr1', $sale->address);
            $shipment->setParameter('toAddr2', $sale->address2);
            $shipment->setParameter('toCity', $sale->city);
            $shipment->setParameter('toState', $abv);
            $shipment->setParameter('toCode', $sale->zip);

                $items = DB::select("SELECT
                                        sales_order_items.quantity as quantity,
                                        products.length as length,
                                        products.width as width,
                                        products.height as height,
                                        products.weight as weight
                                    FROM sales_order_items
                                    LEFT JOIN products ON (products.sku = sales_order_items.aid)
                                    WHERE sales_order_items.so_id = $sale->id");

                foreach ($items as $item) {

                    $qty = $item->quantity;

                    $package = new \RocketShipIt\Package('UPS');
                    $package->setParameter('length',$item->length);
                    $package->setParameter('width',$item->width);
                    $package->setParameter('height',$item->height);
                    $package->setParameter('weight',$item->weight);
                    $package->setParameter('referenceCode','ON');
                    $package->setParameter('referenceValue', $sale->id);

                    for ($i=0; $i < $qty; $i++) {
                        $shipment->addPackageToShipment($package);

                        $ship_qty += 1;
                    }
                }

           $response = $shipment->submitShipment();

           var_dump($response);

            $orderShipment = new OrderShipment;
            $orderShipment->so_id = $sale->id;
            $orderShipment->main_tracking = $response["trk_main"];
            $orderShipment->charges = $response["charges"];
            $orderShipment->negotiated_charges = $response["negotiated_charges"];
            $orderShipment->save();

            for ($i=0; $i < $ship_qty; $i++) {

                $shipmentpack = new ShipmentPackage;
                $shipmentpack->ship_id = $orderShipment->id;
                $shipmentpack->tracking_num = $response["pkgs"][$i]["pkg_trk_num"];
                $shipmentpack->label_fmt = $response["pkgs"][$i]["label_fmt"];
                $shipmentpack->label_img = $response["pkgs"][$i]["label_img"];
                $shipmentpack->save();
            }


            $order = SalesOrder::find($sale->id);
            $order->status = "shipped";
            $order->save();

            print($shipment->debug());

            unset($shipment);
            unset($response);
            unset($package);
            unset($qty);


        }

        //return Redirect::to('/shipments');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**m
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        //$shipmentpack = ShipmentPackage::where('tracking_num', '=', $id)->update(array('scanned' => 0));

        $sales = DB::select("SELECT
            sales_orders.id as id,
            sales_orders.order_id as order_id,
            sales_orders.purchase_date as purchase_date,
            sales_orders.buyer_name as name,
            sales_orders.ship_phone as phone,
            sales_orders.ship_address1 as address,
            sales_orders.ship_city as city,
            sales_orders.ship_state as state,
            sales_orders.ship_zip as zip,
            sales_orders.purchase_source as source
        FROM shipment_packages
        LEFT JOIN shipments ON (shipments.id = shipment_packages.ship_id)
        LEFT JOIN sales_orders ON (sales_orders.id = shipments.so_id)
        WHERE shipment_packages.tracking_num = '$id'");

        $order = json_decode(json_encode($sales), true);
        $order_id = $order[0]["id"];

        $purchase_source = json_decode(json_encode($sales), true);
        $source = $purchase_source[0]["source"];

        $items = DB::select("SELECT sales_order_items.*, products.title FROM sales_order_items LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_order_items.so_id = $order_id");

        $label = DB::select("SELECT label_img FROM shipment_packages WHERE tracking_num = '$id'");

        foreach ($label as $result)
        {
            $data = base64_decode($result->label_img);
            $im = new Imagick();
            $im->readImageBlob($data);
            $im->setImageFormat("jpeg");
            $im->rotateImage(new ImagickPixel(), 90);
            $label = base64_encode($im);
            $im->clear();
            $im->destroy();
        }

        return View::make('shipments.show', array(
                'sales'   => $sales,
                'label'   => $label,
                'items'   => $items,
                'source'  => $source,
                ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $shipmentpack = ShipmentPackage::where('tracking_num', '=', $id);
        $shipmentpack->scanned = 1;
        $shipmentpack->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $shipmentpack = ShipmentPackage::find($id);
        $shipmentpack->status = 'canceled';
        $shipmentpack->save();
    }

    public function scanned()
    {
        $tracking_num = Input::get('tracking_num');

        ShipmentPackage::where('tracking_num', '=', $tracking_num)->update(array('scanned' => 1));

        return Redirect::to('/shipments');
    }

    public function void($ship_id, $order_id)
    {
        $packages = DB::select("SELECT shipment_packages.tracking_num FROM shipments LEFT JOIN shipment_packages ON ( shipments.id = shipment_packages.ship_id ) WHERE shipments.main_tracking = '$id'");

        foreach ($packages as $package) {

            $void = new \RocketShipIt\Void('UPS');
            $response = $void->voidShipment($package->tracking_num);

            $ship_package = ShipmentPackage::where('tracking_num', '=', $package->tracking_num);
            $ship_package->delete();
        }

        $order_ship = OrderShipment::where('main_tracking', '=', $ship_id);
        $order_ship->delete();


        return Redirect::to('/sales-orders/'.$order_id);
    }
}
