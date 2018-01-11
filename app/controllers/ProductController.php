<?php

class ProductController extends \BaseController {

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
                $products = DB::select("SELECT id, aid, sku, amazon_asin, title, cost, price, weight FROM products WHERE seller_id = '$user->company'");

            }

            else 
            {
                $products = DB::select("SELECT id, aid, sku, amazon_asin, title, cost, price, weight FROM products");
            }

            $this->layout->content = View::make('product.index', array(
                'products'  => $products,
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
            $manufacturers = DB::select("SELECT id, title FROM manufacturers");
            $suppliers = DB::select("SELECT id, title FROM suppliers");

            $this->layout->content = View::make('product.create', array(
                    'user'  => $user,
                    'sellers'   => $sellers,
                    'manufacturers'   => $manufacturers,
                    'suppliers'   => $suppliers,
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

                $query = "SELECT COUNT(products.id) as counter , sellers.prefixer AS prefix FROM products LEFT JOIN sellers ON (products.seller_id = sellers.id) where products.seller_id = '$seller' AND sellers.id = (SELECT id from sellers where  sellers.id = products.seller_id LIMIT 1)";
                $results = DB::select($query);

                foreach ($results as $result) {
                    $count = (int)$result->counter + 1;
                    $prefix = $result->prefix;
                    if ($count < 10)
                    {
                        $aid = $prefix.'0'.(string)$count;
                    }
                    else
                    {
                        $aid = $prefix.(string)$count;
                    }
                    
                }

                $product = new Product;
                $product->seller_id = $seller;
                $product->aid = $aid;
                $product->sku = Input::get('sku');
                $product->mfp = Input::get('mfp');
                $product->amazon_asin = Input::get('amazon_asin');
                $product->title = Input::get('title');

                if ($_FILES["image"]['size'] > 0) {

                    $newfilename = date("YmdHis").str_random(8).'.jpg';
                    $destinationPath = 'upload/products/'.$seller.'/'.$aid.'/';
                    Input::file('image')->move($destinationPath, $newfilename);
                    $product->image = $newfilename;
                }

                $product->manufacturer_id = Input::get('manufacturer_id');
                $product->supplier_id = Input::get('supplier_id');
                $product->msrp = Input::get('msrp');
                $product->cost = Input::get('cost');
                $product->price = Input::get('price');
                $product->weight = Input::get('weight');
                $product->length = Input::get('length');
                $product->width = Input::get('width');
                $product->height = Input::get('height');
                $product->save();

                return Redirect::to('/products');
            }

            catch (\Exception $e)
            {
                echo "Failed : Creating the Manufacturer";
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
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {

                $products = DB::select("SELECT products.id as product_id, products.aid, sku, mfp, products.seller_id as seller, products.title as product, products.image as image, price, cost, msrp, weight, length, width, height, suppliers.title as supplier, manufacturers.title as manufacturer, products.aid FROM products LEFT JOIN suppliers ON (suppliers.id = products.supplier_id) LEFT JOIN manufacturers ON (manufacturers.id = products.manufacturer_id) WHERE products.id = '$id'"); 
                $checkins = DB::select("SELECT IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) as quantity FROM products LEFT JOIN ( SELECT purchase_order_items.id as item_id,  purchase_order_items.aid as item_aid FROM purchase_order_items ) AS poi ON (poi.item_aid = products.aid) LEFT JOIN purchase_order_checkins ON (purchase_order_checkins.poi_id = poi.item_id) WHERE products.id = '$id'");
                $sales = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as quantity FROM products LEFT JOIN sales_order_items ON (sales_order_items.aid = products.sku) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND NOT (sales_orders.status = 'returned' OR  sales_orders.status = 'canceled')");
                $adjustments = DB::select("SELECT IFNULL( SUM( adjustment_memos.quantity ) , 0 ) as quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $id GROUP BY adjustment_memos.aid");

                $checkins_array = json_decode(json_encode($checkins), true);
                $sales_array = json_decode(json_encode($sales), true);
                $adjustments_array = json_decode(json_encode($adjustments), true);

                if ($checkins_array[0]['quantity'] == NULL) { $checkins = 0;} else { $checkins = $checkins_array[0]['quantity'];}
                if ($sales_array[0]['quantity'] == NULL) { $sales = 0;} else { $sales = $sales_array[0]['quantity'];}
                if (!isset($adjustments_array[0]['quantity'])) { $adjustments = 0;} else { $adjustments = $adjustments_array[0]['quantity'];}

                $checkin_history = DB::select("SELECT purchase_order_items.po_id AS po, purchase_order_checkins.quantity AS qty, purchase_order_checkins.created_at AS date_received FROM products LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) WHERE products.id = $id");
                $adjustments_history = DB::select("SELECT adjustment_memos.quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $id");

                $par_vars = DB::select("SELECT IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0) as past30,  IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0)  as past7 FROM products WHERE id = $id");
                
                foreach ($par_vars as $par_var) {
                    $par = ceil((((($par_var->past30 / 30) * 7) + $par_var->past7) * 2) / 14);
                    $dif = ceil(((($par_var->past30 / 30) * 7) + $par_var->past7) * 2);
                }

                //$dif = $par - $dif;

                $date1 = new DateTime(date("Y-m-d"));
                $date2 = new DateTime(date("Y-m-d", strtotime("next tuesday")));

                $datediff = $date1->diff($date2);

                $diff = json_decode(json_encode($datediff), true);

                $lead = $diff["d"] + 7;

                $forecast = $par*$lead;

                $est_purchase = ($forecast - ($checkins - $sales + $adjustments));

                if($est_purchase <= 0)
                {
                    $est_purchase = 0;
                }

                $this->layout->content = View::make('product.show', array(
                    'products'  => $products,
                    'checkins'  => $checkins,
                    'adjustments'  => $adjustments,
                    'checkin_history' => $checkin_history,
                    'adjustments_history' => $adjustments_history,
                    'sales'  => $sales,
                    'dif' => $dif,
                    'id'    => $id,
                    'forecast' => $forecast,
                    'est_purchase' => $est_purchase,
                    ));
            }

            else
            {

                $products = DB::select("SELECT products.id as product_id, products.aid, sku, mfp, products.seller_id as seller, products.title as product, products.image as image, price, cost, msrp, weight, length, width, height, suppliers.title as supplier, manufacturers.title as manufacturer, products.aid FROM products LEFT JOIN suppliers ON (suppliers.id = products.supplier_id) LEFT JOIN manufacturers ON (manufacturers.id = products.manufacturer_id) WHERE products.id = '$id'"); 
                $checkins = DB::select("SELECT IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) as quantity FROM products LEFT JOIN ( SELECT purchase_order_items.id as item_id,  purchase_order_items.aid as item_aid FROM purchase_order_items ) AS poi ON (poi.item_aid = products.aid) LEFT JOIN purchase_order_checkins ON (purchase_order_checkins.poi_id = poi.item_id) WHERE products.id = '$id'");
                $sales = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) as quantity FROM products LEFT JOIN sales_order_items ON (sales_order_items.aid = products.sku) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND NOT (sales_orders.status = 'returned' OR  sales_orders.status = 'canceled')");
                $adjustments = DB::select("SELECT IFNULL( SUM( adjustment_memos.quantity ) , 0 ) as quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $id GROUP BY adjustment_memos.aid");

                $checkins_array = json_decode(json_encode($checkins), true);
                $sales_array = json_decode(json_encode($sales), true);
                $adjustments_array = json_decode(json_encode($adjustments), true);

                if ($checkins_array[0]['quantity'] == NULL) { $checkins = 0;} else { $checkins = $checkins_array[0]['quantity'];}
                if ($sales_array[0]['quantity'] == NULL) { $sales = 0;} else { $sales = $sales_array[0]['quantity'];}
                if (!isset($adjustments_array[0]['quantity'])) { $adjustments = 0;} else { $adjustments = $adjustments_array[0]['quantity'];}

                $checkin_history = DB::select("SELECT purchase_order_items.po_id AS po, purchase_order_checkins.quantity AS qty, purchase_order_checkins.created_at AS date_received FROM products LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) WHERE products.id = $id");
                $adjustments_history = DB::select("SELECT adjustment_memos.quantity, adjustment_memos.memo as memo FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $id");

                $par_vars = DB::select("SELECT IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0) as past30,  IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0)  as past7 FROM products WHERE id = $id");
                
                foreach ($par_vars as $par_var) {
                    $par = ceil((((($par_var->past30 / 30) * 7) + $par_var->past7) * 2) / 14);
                    $dif = ceil(((($par_var->past30 / 30) * 7) + $par_var->past7) * 2);
                }

                //$dif = $par - $dif;

                $date1 = new DateTime(date("Y-m-d"));
                $date2 = new DateTime(date("Y-m-d", strtotime("next tuesday")));

                $datediff = $date1->diff($date2);

                $diff = json_decode(json_encode($datediff), true);

                $lead = $diff["d"] + 7;

                $forecast = $par*$lead;

                $est_purchase = ($forecast - ($checkins - $sales + $adjustments));

                if($est_purchase <= 0)
                {
                    $est_purchase = 0;
                }

                $this->layout->content = View::make('product.show', array(
                    'products'  => $products,
                    'checkins'  => $checkins,
                    'adjustments'  => $adjustments,
                    'checkin_history' => $checkin_history,
                    'adjustments_history' => $adjustments_history,
                    'sales'  => $sales,
                    'dif' => $dif,
                    'id'    => $id,
                    'forecast' => $forecast,
                    'est_purchase' => $est_purchase,
                    ));
            }
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
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {
                $products = DB::select("SELECT * FROM products WHERE id = '$id'");
                $sellers = DB::select("SELECT id, company FROM sellers");
                $manufacturers = DB::select("SELECT id, title FROM manufacturers");
                $suppliers = DB::select("SELECT id, title FROM suppliers");
                $this->layout->content = View::make('product.edit', array(
                    'products'  => $products,
                    'sellers'   => $sellers,
                    'manufacturers'   => $manufacturers,
                    'suppliers'   => $suppliers,
                    'id'    => $id,
                    ));
            }

            else
            {

                $products = DB::select("SELECT * FROM products WHERE id = '$id'");
                $sellers = DB::select("SELECT id, company FROM sellers");
                $manufacturers = DB::select("SELECT id, title FROM manufacturers");
                $suppliers = DB::select("SELECT id, title FROM suppliers");
                $this->layout->content = View::make('product.edit', array(
                    'products'  => $products,
                    'sellers'   => $sellers,
                    'manufacturers'   => $manufacturers,
                    'suppliers'   => $suppliers,
                    'id'    => $id,
                    ));
            }
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

                $tests = DB::select("SELECT aid FROM products WHERE id = " . $id);
                $array = json_decode(json_encode($tests), true);
                $aid = $array[0]['aid'];

                $product = Product::find($id);
                $product->seller_id = $seller;
                $product->sku = Input::get('sku');
                $product->mfp = Input::get('mfp');
                $product->amazon_asin = Input::get('amazon_asin');
                $product->title = Input::get('title');

                if ($_FILES["image"]['size'] > 0) {

                    $newfilename = date("YmdHis").str_random(8).'.jpg';
                    $destinationPath = 'upload/products/'.$seller.'/'.$aid.'/';
                    Input::file('image')->move($destinationPath, $newfilename);
                    $product->image = $newfilename;
                }

                $product->manufacturer_id = Input::get('manufacturer_id');
                $product->supplier_id = Input::get('supplier_id');
                $product->msrp = Input::get('msrp');
                $product->cost = Input::get('cost');
                $product->price = Input::get('price');
                $product->weight = Input::get('weight');
                $product->length = Input::get('length');
                $product->width = Input::get('width');
                $product->height = Input::get('height');
                $product->save();

                return Redirect::to('/products/'.$id);
            }

            catch (\Exception $e)
            {
                echo "Failed : Creating the Manufacturer";
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
            $user = Sentry::getUser();

            if ($user->hasAccess('admin') != True)
            {
                $this->layout->content = View::make('');
            }
            
            else
            {

            }
        }
    }


}