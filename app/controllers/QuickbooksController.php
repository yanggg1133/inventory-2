<?php

setlocale(LC_MONETARY, 'en_US.UTF-8');
class QuickbooksController extends \BaseController {


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
            $this->layout->content = View::make('quickbooks.index');
        }
    }

    public function amazon()
        {
            if (!Sentry::check())
            {
                return Redirect::to('/');
            }
            else
            {

                        if (isset($_GET["start"]))
                        {
                            $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                            $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));
                        }

                        $products = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazon = array();
                        $qty = array();
                        $fee = array();
                        $tax = array();
                        $ship = array();
                        $total = array();

                        foreach ($products as $product) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $qty[] = $result->qty;
                                    $total[] = $result->total;
                                    $tax[] = $result->tax;
                                    $ship[] = $result->shipping;
                                    $fee[] = $result->fee;

                                    $amazon[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazon = json_decode(json_encode($amazon), true);

                        $qty = array_sum($qty);
                        $total = array_sum($total);
                        $tax = array_sum($tax);
                        $ship = array_sum($ship);
                        $fee = array_sum($fee);

                        $details = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                        $this->layout->content = View::make('quickbooks.results', array(
                                'amazon' => $amazon,
                                'customer' => 'Amazon',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'qty' => $qty,
                                'total' => $total,
                                'tax' => $tax,
                                'ship' => $ship,
                                'fee' => $fee,
                                'details' => $details
                            ));

            }

        }

    public function amazonfl()
        {
            if (!Sentry::check())
            {
                return Redirect::to('/');
            }
            else
            {
                    if (isset($_GET["start"]))
                        {
                            $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                            $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));
                        }

                        $products = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazon = array();
                        $qty = array();
                        $fee = array();
                        $tax = array();
                        $ship = array();
                        $total = array();

                        foreach ($products as $product) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $qty[] = $result->qty;
                                    $total[] = $result->total;
                                    $tax[] = $result->tax;
                                    $ship[] = $result->shipping;
                                    $fee[] = $result->fee;

                                    $amazon[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazon = json_decode(json_encode($amazon), true);

                        $qty = array_sum($qty);
                        $total = array_sum($total);
                        $tax = array_sum($tax);
                        $ship = array_sum($ship);
                        $fee = array_sum($fee);

                        $details = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");


                        $this->layout->content = View::make('quickbooks.results', array(
                                'amazon' => $amazon,
                                'customer' => 'Amazon FL',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'qty' => $qty,
                                'total' => $total,
                                'ship' => $ship,
                                'tax' => $tax,
                                'fee' => $fee,
                                'details' => $details
                            ));
            }

        }

    public function cscart()
        {
            if (!Sentry::check())
            {
                return Redirect::to('/');
            }
            else
            {

                    if (isset($_GET["start"]))
                        {
                            $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                            $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));
                        }

                        $products = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazon = array();
                        $qty = array();
                        $fee = array();
                        $tax = array();
                        $ship = array();
                        $total = array();

                        foreach ($products as $product) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $qty[] = $result->qty;
                                    $total[] = $result->total;
                                    $tax[] = $result->tax;
                                    $ship[] = $result->shipping;
                                    $fee[] = $result->fee;

                                    $amazon[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazon = json_decode(json_encode($amazon), true);

                        $qty = array_sum($qty);
                        $total = array_sum($total);
                        $tax = array_sum($tax);
                        $ship = array_sum($ship);
                        $fee = array_sum($fee);

                        $gross = ($total+$tax+$ship);
                        $net = ($total+$tax+$ship)-$fee;

                        $details = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");


                        $this->layout->content = View::make('quickbooks.results', array(
                                'amazon' => $amazon,
                                'customer' => 'Website',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'qty' => $qty,
                                'total' => $total,
                                'ship' => $ship,
                                'tax' => $tax,
                                'fee' => $fee,
                                'gross' => $gross,
                                'net' => $net,
                                'details' => $details
                            ));
            }

        }

    public function cscartfl()
        {
            if (!Sentry::check())
            {
                return Redirect::to('/');
            }
            else
            {

                    if (isset($_GET["start"]))
                        {
                            $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                            $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));
                        }

                        $products = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazon = array();
                        $qty = array();
                        $fee = array();
                        $tax = array();
                        $ship = array();
                        $total = array();

                        foreach ($products as $product) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $qty[] = $result->qty;
                                    $total[] = $result->total;
                                    $tax[] = $result->tax;
                                    $ship[] = $result->shipping;
                                    $fee[] = $result->fee;

                                    $amazon[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$product->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazon = json_decode(json_encode($amazon), true);

                        $qty = array_sum($qty);
                        $total = array_sum($total);
                        $tax = array_sum($tax);
                        $ship = array_sum($ship);
                        $fee = array_sum($fee);

                        $details = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");


                        $this->layout->content = View::make('quickbooks.results', array(
                                'amazon' => $amazon,
                                'customer' => 'Website FL',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'qty' => $qty,
                                'total' => $total,
                                'ship' => $ship,
                                'tax' => $tax,
                                'fee' => $fee,
                                'details' => $details
                            ));
            }

        }

        public function reports()
        {
            if (!Sentry::check())
            {
                return Redirect::to('/');
            }
            else
            {

                    if (isset($_GET["start"]))
                        {
                            $start_date = date('Y-m-d H:i:s', strtotime(urldecode($_GET["start"])));
                            $end_date = date('Y-m-d 23:59:59', strtotime(urldecode($_GET["end"])));
                        }

                        $amazonproducts = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazon = array();
                        $amazonqty = array();
                        $amazonfee = array();
                        $amazontax = array();
                        $amazonship = array();
                        $amazontotal = array();

                        foreach ($amazonproducts as $amazonproduct) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$amazonproduct->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.amazon_update BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $amazonqty[] = $result->qty;
                                    $amazontotal[] = $result->total;
                                    $amazontax[] = $result->tax;
                                    $amazonship[] = $result->shipping;
                                    $amazonfee[] = $result->fee;

                                    $amazon[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$amazonproduct->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.amazon_update BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazon = json_decode(json_encode($amazon), true);

                        $amazonqty = array_sum($amazonqty);
                        $amazontotal = array_sum($amazontotal);
                        $amazontax = array_sum($amazontax);
                        $amazonship = array_sum($amazonship);
                        $amazonfee = array_sum($amazonfee);

                        $amazondetails = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                        $amazonflproducts = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $amazonfl = array();
                        $amazonflqty = array();
                        $amazonflfee = array();
                        $amazonfltax = array();
                        $amazonflship = array();
                        $amazonfltotal = array();

                        foreach ($amazonflproducts as $amazonflproduct) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$amazonflproduct->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.amazon_update BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $amazonflqty[] = $result->qty;
                                    $amazonfltotal[] = $result->total;
                                    $amazonfltax[] = $result->tax;
                                    $amazonflship[] = $result->shipping;
                                    $amazonflfee[] = $result->fee;

                                    $amazonfl[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.total IS NOT NULL , SUM( sales_order_items.total ) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$amazonflproduct->sku' AND sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.amazon_update BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $amazonfl = json_decode(json_encode($amazonfl), true);

                        $amazonflqty = array_sum($amazonflqty);
                        $amazonfltotal = array_sum($amazonfltotal);
                        $amazonfltax = array_sum($amazonfltax);
                        $amazonflship = array_sum($amazonflship);
                        $amazonflfee = array_sum($amazonflfee);

                        $amazonfldetails = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.purchase_date, sales_order_items.quantity, sales_order_items.total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'amazon' AND sales_orders.ship_state = 'FL' AND sales_orders.amazon_update BETWEEN '$start_date' AND '$end_date'");

                        $websiteproducts = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $website = array();
                        $websiteqty = array();
                        $websitefee = array();
                        $websitetax = array();
                        $websiteship = array();
                        $websitetotal = array();

                        foreach ($websiteproducts as $websiteproduct) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.cost_per_item IS NOT NULL , SUM( sales_order_items.cost_per_item * sales_order_items.quantity) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$websiteproduct->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $websiteqty[] = $result->qty;
                                    $websitetotal[] = $result->total;
                                    $websitetax[] = $result->tax;
                                    $websiteship[] = $result->shipping;
                                    $websitefee[] = $result->fee;

                                    $website[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.cost_per_item IS NOT NULL , SUM( sales_order_items.cost_per_item * sales_order_items.quantity) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$websiteproduct->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $website = json_decode(json_encode($website), true);

                        $websiteqty = array_sum($websiteqty);
                        $websitetotal = array_sum($websitetotal);
                        $websitetax = array_sum($websitetax);
                        $websiteship = array_sum($websiteship);
                        $websitefee = array_sum($websitefee);

                        $websitegross = ($websitetotal+$websitetax+$websiteship);
                        $websitenet = ($websitetotal+$websitetax+$websiteship)-$websitefee;

                        $websitedetails = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.buyer_name, sales_orders.purchase_date, sales_order_items.quantity,IF( sales_order_items.cost_per_item IS NOT NULL , sales_order_items.cost_per_item * sales_order_items.quantity , 0 ) as total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state != 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                        $websiteflproducts = DB::select("SELECT * FROM products WHERE seller_id = 1 ORDER BY sku");

                        $websitefl = array();
                        $websiteflqty = array();
                        $websiteflfee = array();
                        $websitefltax = array();
                        $websiteflship = array();
                        $websitefltotal = array();

                        foreach ($websiteflproducts as $websiteflproduct) {

                            $query = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.cost_per_item IS NOT NULL , SUM( sales_order_items.cost_per_item * sales_order_items.quantity) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$websiteflproduct->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                            foreach ($query as $result) {

                                if ($result->qty > 0) {

                                    $websiteflqty[] = $result->qty;
                                    $websitefltotal[] = $result->total;
                                    $websitefltax[] = $result->tax;
                                    $websiteflship[] = $result->shipping;
                                    $websiteflfee[] = $result->fee;

                                    $websitefl[] = DB::select("SELECT products.qbid as product, IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as qty, IF( sales_order_items.cost_per_item IS NOT NULL , SUM( sales_order_items.cost_per_item * sales_order_items.quantity) , 0 ) as total, IF( sales_order_items.shipping IS NOT NULL , SUM( sales_order_items.shipping ) , 0 ) as shipping, IF( sales_order_items.tax IS NOT NULL , SUM( sales_order_items.tax ) , 0 ) as tax, IF( sales_order_items.fee IS NOT NULL , SUM( sales_order_items.fee ) , 0 ) as fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND sales_orders.status != 'canceled' AND sales_order_items.aid = '$websiteflproduct->sku' AND sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");
                                }

                            }

                        }

                        $websitefl = json_decode(json_encode($websitefl), true);

                        $websiteflqty = array_sum($websiteflqty);
                        $websitefltotal = array_sum($websitefltotal);
                        $websitefltax = array_sum($websitefltax);
                        $websiteflship = array_sum($websiteflship);
                        $websiteflfee = array_sum($websiteflfee);

                        $websiteflgross = ($websitefltotal+$websitefltax+$websiteflship);
                        $websiteflnet = ($websitefltotal+$websitefltax+$websiteflship)-$websiteflfee;

                        $websitefldetails = DB::SELECT("SELECT products.qbid, sales_orders.order_id, sales_orders.buyer_name, sales_orders.purchase_date, sales_order_items.quantity,IF( sales_order_items.cost_per_item IS NOT NULL , sales_order_items.cost_per_item * sales_order_items.quantity , 0 ) as total, sales_order_items.shipping, sales_order_items.tax, sales_order_items.fee FROM sales_orders LEFT JOIN sales_order_items ON (sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (products.sku = sales_order_items.aid) WHERE sales_orders.purchase_source = 'cs-cart' AND sales_orders.ship_state = 'FL' AND sales_orders.purchase_date BETWEEN '$start_date' AND '$end_date'");

                        $this->layout->content = View::make('quickbooks.allresults', array(
                                'amazon' => $amazon,
                                'amazoncustomer' => 'Amazon',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'amazonqty' => $amazonqty,
                                'amazontotal' => $amazontotal,
                                'amazontax' => $amazontax,
                                'amazonship' => $amazonship,
                                'amazonfee' => $amazonfee,
                                'amazondetails' => $amazondetails,'amazonfl' => $amazonfl,
                                'amazonflcustomer' => 'Amazon FL',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'amazonflqty' => $amazonflqty,
                                'amazonfltotal' => $amazonfltotal,
                                'amazonflship' => $amazonflship,
                                'amazonfltax' => $amazonfltax,
                                'amazonflfee' => $amazonflfee,
                                'amazonfldetails' => $amazonfldetails,
                                'website' => $website,
                                'websitecustomer' => 'Website',
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'websiteqty' => $websiteqty,
                                'websitetotal' => $websitetotal,
                                'websiteship' => $websiteship,
                                'websitetax' => $websitetax,
                                'websitefee' => $websitefee,
                                'websitedetails' => $websitedetails,
                                'websitefl' => $websitefl,
                                'websiteflcustomer' => 'Website FL',
                                'websiteflstart_date' => $start_date,
                                'websiteflend_date' => $end_date,
                                'websiteflqty' => $websiteflqty,
                                'websitefltotal' => $websitefltotal,
                                'websiteflship' => $websiteflship,
                                'websitefltax' => $websitefltax,
                                'websiteflfee' => $websiteflfee,
                                'websitefldetails' => $websitefldetails,
                                'websitegross' => $websitegross,
                                'websitenet' => $websitenet,
                                'websiteflgross' => $websiteflgross,
                                'websiteflnet' => $websiteflnet
                            ));
            }
        }

}
