<?php

setlocale(LC_MONETARY, 'en_US.UTF-8');
class ReportController extends \BaseController {


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
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('reports.index', array(
                'sellers' => $sellers,
            ));
        }
    }

    public function salesReport()
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            
            
            

            if (isset($_GET["month"]))
            {
                $month = urldecode($_GET["month"]);
                $year = urldecode($_GET["year"]);

                $span1 = $month;
                $span2 = $year;
            }

            if (isset($_GET["start"]))
            {
                $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));

                $span1 = $start_date;
                $span2 = $end_date;
            }


            $products = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");
                    $cscart[] = null;
                    $amazon[] = null;
                    $ebay[] = null;
                    $cscartcost = 0.00;
                    $cscartqty = 0;
                    $cscartrev = 0.00;
                    $cscartshipping = 0.00;
                    $cscarttax = 0.00;
                    $amazonqty = 0;
                    $amazoncost = 0.00;
                    $amazonrev = 0.00;
                    $amazonshipping = 0.00;
                    $amazontax = 0.00;
                    $ebayqty = 0;
                    $ebaycost = 0.00;
                    $ebayrev = 0.00;
                    $ebayshipping = 0.00;
                    $ebaytax = 0.00;
                    $itemqty_total[] = null;
                    $itemrev_total[] = null;
                    $totalcost[] = null;
                    $totalrev[] = null;
                    $totalqty[] = null;
                    $cscart_adjustment = 0 ;
                    $amazon_adjustment = 0 ;
                    $ebay_adjustment = 0 ;
                    
                    if (isset($_GET["month"]))
                    {
                        $cscart_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'cs-cart' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month GROUP BY sales_orders.id");
                        $amazon_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'amazon' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month GROUP BY sales_orders.id");
                        $ebay_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'ebay' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month GROUP BY sales_orders.id");
                        

                        $cscart_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'cs-cart' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                        $amazon_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'amazon' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                        $ebay_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'ebay' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                    }

                    if (isset($_GET["start"]))
                    {
                        $cscart_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date' GROUP BY sales_orders.id");
                        $amazon_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'amazon' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date' GROUP BY sales_orders.id");
                        $ebay_orders = DB::select("SELECT sales_orders.id as id, IFNULL(SUM(sales_order_items.quantity), 0) as quantity FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'ebay' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date' GROUP BY sales_orders.id");

                        $cscart_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                        $amazon_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'amazon' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                        $ebay_ship = DB::select("SELECT IFNULL(SUM(shipments.negotiated_charges), 0) as shipping_charge FROM sales_orders LEFT JOIN shipments ON (shipments.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.purchase_source = 'ebay' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                    }

                    foreach ($cscart_orders as $cscart_order) {
                        if($cscart_order->quantity > 4 )
                        {
                            $adjust = ceil($cscart_order->quantity / 4);
                            $cscart_adjustment += $adjust;
                        }
                        else
                        {
                            $cscart_adjustment += 1;
                        }
                    }
                    foreach ($amazon_orders as $amazon_order) {
                        if($amazon_order->quantity > 4 )
                        {
                            $adjust = ceil($amazon_order->quantity / 4);
                            $amazon_adjustment += $adjust;
                        }
                        else
                        {
                            $amazon_adjustment += 1;
                        }
                    }
                    foreach ($ebay_orders as $ebay_order) {
                        if($ebay_order->quantity > 4 )
                        {
                            $adjust = ceil($ebay_order->quantity / 4);
                            $amazon_adjustment += $adjust;
                        }
                        else
                        {
                            $ebay_adjustment += 1;
                        }
                    }

                foreach ($products as $product) {
                    if (isset($_GET["month"]))
                    {
                        $cscart[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.cost_per_item *  sales_order_items.quantity ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                        $amazon[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                        $ebay[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND  sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'ebay' AND YEAR( purchase_date ) = $year AND MONTH( purchase_date ) = $month");
                    }

                    if (isset($_GET["start"]))
                    {
                        $cscart[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                        $amazon[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                        $ebay[$product->sku] = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as rev, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND  sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'ebay' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'  ");
                    }

                    $itemqty_total[$product->sku] = 0;
                    $itemrev_total[$product->sku] = 0;

                    $cscart = json_decode(json_encode($cscart), true);
                    $amazon = json_decode(json_encode($amazon), true);
                    $ebay = json_decode(json_encode($ebay), true);

                    if ($cscart["$product->sku"] != null)
                    {
                        $itemqty_total["$product->sku"] += $cscart["$product->sku"][0]["qty"];
                        $itemrev_total["$product->sku"] += $cscart["$product->sku"][0]["rev"];
                        $cscartcost += ($cscart["$product->sku"][0]["qty"] * $product->cost);
                        $cscartqty += $cscart["$product->sku"][0]["qty"];
                        $cscartrev += $cscart["$product->sku"][0]["rev"];
                        $cscartshipping += $cscart["$product->sku"][0]["shipping"];
                        $cscarttax += $cscart["$product->sku"][0]["tax"];
                        array_push($totalcost,($cscart["$product->sku"][0]["qty"] * $product->cost));
                        array_push($totalqty,$cscart["$product->sku"][0]["qty"]);
                        array_push($totalrev,$cscart["$product->sku"][0]["rev"]);


                    }
                    
                    if ($amazon["$product->sku"] != null)
                    {
                        $itemqty_total["$product->sku"] += $amazon["$product->sku"][0]["qty"];
                        $itemrev_total["$product->sku"] += $amazon["$product->sku"][0]["rev"];
                        $amazoncost += ($amazon["$product->sku"][0]["qty"] * $product->cost);
                        $amazonqty += $amazon["$product->sku"][0]["qty"];
                        $amazonrev += $amazon["$product->sku"][0]["rev"];
                        $amazonshipping += $amazon["$product->sku"][0]["shipping"];
                        $amazontax += $amazon["$product->sku"][0]["tax"];
                        array_push($totalcost,($amazon["$product->sku"][0]["qty"] * $product->cost));
                        array_push($totalqty,$amazon["$product->sku"][0]["qty"]);
                        array_push($totalrev,$amazon["$product->sku"][0]["rev"]);
                    }

                    if ($ebay["$product->sku"] != null)
                    {
                        $itemqty_total["$product->sku"] += $ebay["$product->sku"][0]["qty"];
                        $itemrev_total["$product->sku"] += $ebay["$product->sku"][0]["rev"];
                        $ebaycost += ($ebay["$product->sku"][0]["qty"] *  $product->cost);
                        $ebayqty += $ebay["$product->sku"][0]["qty"];
                        $ebayrev += $ebay["$product->sku"][0]["rev"];
                        $ebayshipping += $ebay["$product->sku"][0]["shipping"];
                        $ebaytax += $ebay["$product->sku"][0]["tax"];
                        array_push($totalcost,($ebay["$product->sku"][0]["qty"] * $product->cost));
                        array_push($totalqty,$ebay["$product->sku"][0]["qty"]);
                        array_push($totalrev,$ebay["$product->sku"][0]["rev"]);
                    }

                }

                $totalcost = array_sum($totalcost);
                $totalqty = array_sum($totalqty);
                $totalrev = array_sum($totalrev);

            $this->layout->content = View::make('reports.sales', array(
                'products' => $products,
                'cscart' => $cscart,
                'amazon' => $amazon,
                'ebay' => $ebay,
                'itemqty_total' => $itemqty_total,
                'itemrev_total' => $itemrev_total,
                'totalcost' =>$totalcost,
                'totalqty' => $totalqty,
                'totalrev' => $totalrev,
                'cscartcost' => $cscartcost,
                'cscartqty' => $cscartqty,
                'cscartrev' => $cscartrev,
                'amazoncost' => $amazoncost,
                'amazonqty' => $amazonqty,
                'amazonrev' => $amazonrev,
                'ebaycost' =>   $ebaycost,
                'ebayqty' =>   $ebayqty,
                'ebayrev' =>   $ebayrev,
                'cscartshipping' => $cscartshipping,
                'cscarttax' => $cscarttax,
                'amazonshipping' => $amazonshipping,
                'amazontax' => $amazontax,
                'ebayshipping' => $ebayshipping,
                'ebaytax' => $ebaytax,
                'cscart_orders' => $cscart_adjustment,
                'amazon_orders' => $amazon_adjustment,
                'ebay_orders' => $ebay_adjustment,
                'total_orders' => ($ebay_adjustment + $amazon_adjustment + $cscart_adjustment),
                'cscart_ship' => json_decode(json_encode($cscart_ship), true),
                'amazon_ship' => json_decode(json_encode($amazon_ship), true),
                'ebay_ship' => json_decode(json_encode($ebay_ship), true),
                'span1' => $span1,
                'span2' => $span2,
                ));
        }

    }

    public function inventoryReport($seller)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $total_worth = array() ;

            $products = DB::select("SELECT products.id as id, products.title AS title, products.sku as sku, products.cost as cost, IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS ordered, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) AS sold FROM  `products` LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) LEFT JOIN sales_order_items ON ( sales_order_items.aid = products.sku ) WHERE seller_id = $seller GROUP BY products.sku");

            foreach ($products as $product)
            {
                $sales = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) AS sold FROM  `products` LEFT JOIN sales_order_items ON ( sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status = 'canceled') AND products.sku = '$product->sku'");
                        $ordered = DB::select("SELECT IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS ordered FROM  `products` LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) WHERE products.sku = '$product->sku'");

                $sales = json_decode(json_encode($sales), true);
                $ordered = json_decode(json_encode($ordered), true);

                $total = ($ordered[0]["ordered"] - $sales[0]["sold"]) * $product->cost;
                array_push($total_worth, $total);
            }

            $total_worth_raw = $total_worth;
            $total_worth = array_sum($total_worth);

            $this->layout->content = View::make('reports.inventory', array(
                'products'  => $products,
                'total_worth' => $total_worth,
                'total_worth_raw' => $total_worth_raw,
                ));
        }
    }


    public function shippingReport() 
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $month = urldecode($_GET["month"]);
            $year = urldecode($_GET["year"]);

            $shipments = DB::select("SELECT  shipments.created_at as ship_date, sales_orders.order_id, sales_orders.id, sales_orders.purchase_source, shipments.main_tracking, sales_order_items.quantity, shipments.negotiated_charges FROM sales_orders LEFT JOIN sales_order_items ON ( sales_order_items.so_id = sales_orders.id ) LEFT JOIN shipments ON ( sales_orders.id = shipments.so_id ) WHERE  YEAR(shipments.created_at) = $year AND MONTH(shipments.created_at) = $month AND sales_orders.status =  'shipped'");
            
            $order_count = count($shipments);
            $tire_count = 0;
            $shipping_cost = 0.00;

            foreach ($shipments as $shipment) {
                $tire_count += $shipment->quantity;
                $shipping_cost += $shipment->negotiated_charges;
            }
        }

        $this->layout->content = View::make('reports.shipping', array(
                'shipments'  => $shipments,
                'tire_count'  => $tire_count,
                'shipping_cost'  => $shipping_cost,
                'order_count'  => $order_count,
                ));
    }

    public function purchaseReport($seller)
    {
        if (!Sentry::check())
        {
            return Redirect::to('/');
        }
        else
        {
            $total_worth = array() ;

            $products = DB::select("SELECT products.id as id, products.title AS title, products.sku as sku, products.cost as cost, IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS ordered, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) AS sold FROM  `products` LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) LEFT JOIN sales_order_items ON ( sales_order_items.aid = products.sku ) WHERE seller_id = $seller GROUP BY products.sku");

            $this->layout->content = View::make('reports.purchase', array(
                'products'  => $products,
                ));
        }
    }

}
