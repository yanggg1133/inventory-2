<?php

date_default_timezone_set("UTC");



include app_path()."/controllers/apis/cscart.php";
include app_path()."/controllers/apis/ebay.php";
include app_path()."/controllers/apis/amazon.php";
include app_path()."/controllers/libs/shipinfo.php";

class ApiPullController extends \BaseController {

	function getOrders($appkey)
	{


		$pull = DB::select('SELECT * FROM  `user_api_requests` ORDER BY created_at DESC LIMIT 1');
		foreach ($pull as $call) {
			$last_pull = $call->pull_datetime;
		}

		// App Start
		if ($appkey == '72c2bc635388ceda81d5d1941e')
		{
			$sellers = DB::select("SELECT * FROM sellers");

			//Seller Start
			foreach ($sellers as $seller) {
			$current_date = date("Y-m-d\TH:i:s\\Z", time());

			$orders_imported = 0;

				// Grab cscart API Credentials
				$cscarts = DB::select("SELECT * FROM user_api_profiles WHERE seller_id = $seller->id AND provider = 'cs-cart'");

				foreach ($cscarts as $cscart) {

					$auth_user = $cscart->api_cred1;
					$auth_pass = $cscart->api_cred2;
					$cscart_api = new CscartApi();

					$orders = $cscart_api->cscartOrders($auth_user, $auth_pass);

					//echo "<h1>CS-CART PULL</h1>";
					//var_dump($orders);

					$orders_imported += count($orders);
					//var_dump($orders);
					foreach ($orders as $order) {
						$order_id = $order["order_id"];

						$single = $cscart_api->cscartSingleOrders($auth_user, $auth_pass, $order_id);

						try {
							$salesorder = new SalesOrder;
							$salesorder->seller_id = $seller->id;
				            $salesorder->purchase_date = date('Y-m-d H:i:s', $single["timestamp"]);
				            $salesorder->order_id = $order_id;
				            $salesorder->email = $single["email"];
				            $salesorder->buyer_name = $single["s_firstname"].' '. $single["s_lastname"];
				            $salesorder->ship_address1 = $single["s_address"];
				            $salesorder->ship_address2 = $single["s_address_2"];
				            $salesorder->ship_city = $single["s_city"];
				            $salesorder->ship_state = $single["s_state"];
				            $salesorder->ship_zip = $single["s_zipcode"];
				            $salesorder->ship_phone = $single["s_phone"];
				            $salesorder->purchase_source = 'cs-cart';
				            $salesorder->save();

				            foreach ($single["products"] as $product)
							{
					            $salesorderitem = new SalesOrderItem;
								$salesorderitem->so_id = $salesorder->id;
								$salesorderitem->aid = $product["product_code"];
								$salesorderitem->quantity = $product["amount"];
								$salesorderitem->cost_per_item = $product["price"];
								$salesorderitem->total = $single["total"];
								$salesorderitem->shipping = $single["shipping_cost"];
								$salesorderitem->tax = $single["tax_subtotal"];
						        $salesorderitem->save();
							}
						}
						catch (Exception $e) {
							continue;
						}
					}
				} // End of Cs-Cart

				// Grab Ebay API Credentials
				$ebays = DB::select("SELECT * FROM user_api_profiles WHERE seller_id = $seller->id AND provider = 'ebay'");

				foreach ($ebays as $ebay) {

					$auth_token = $ebay->api_cred1;

					$ebay_api = new EbayApi();

					$last_pull = date("Y-m-d\TH:i:s\\Z",strtotime('-7 Days',time()));

					//$last_pull = $last_pull;
					$last_pull = '2015-05-06T00:00:27Z';


					$orders = $ebay_api->ebayOrders($auth_token, $last_pull, $current_date);


					if ($orders != null) {
						//var_dump($orders);



					if(isset($orders["OrderArray"]["Order"][0]))
					{
						$orders_imported += count($orders["OrderArray"]["Order"]);
						$count = count($orders["OrderArray"]["Order"]);

						for ($i=0; $i < $count; $i++)
						{

							preg_match("/\[(.*)\]/s",$orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["Item"]["Title"], $output);

							$sku = null;

							if($output !=null)
							{
								$sku = (string)$output[1];

							}

							if ( $sku != null)
							{
								try{

									$salesorder = new SalesOrder;
									var_dump($salesorder);
									$salesorder->seller_id = $seller->id;
						            $salesorder->purchase_date = date('Y-m-d H:i:s', strtotime($orders["OrderArray"]["Order"][$i]["CreatedTime"]));
						            $salesorder->order_id = $orders["OrderArray"]["Order"][$i]["OrderID"];
						            $salesorder->email = $orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["Buyer"]["Email"];
						            $salesorder->buyer_name = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["Name"];
						            $salesorder->ship_address1 = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["Street1"];
						            //$salesorder->ship_address2 = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["Street2"];
						            $salesorder->ship_city = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["CityName"];
						            $salesorder->ship_state = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["StateOrProvince"];
						            $salesorder->ship_zip = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["PostalCode"];
						            $salesorder->ship_phone = $orders["OrderArray"]["Order"][$i]["ShippingAddress"]["Phone"];
						            $salesorder->purchase_source = 'ebay';
						            $salesorder->save();

						            $salesorderitem = new SalesOrderItem;
									$salesorderitem->so_id = $salesorder->id;
									$salesorderitem->aid = $sku;
									$salesorderitem->quantity = $orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["QuantityPurchased"];
									$salesorderitem->cost_per_item = $orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["TransactionPrice"];
									$salesorderitem->total = $orders["OrderArray"]["Order"][$i]["AmountPaid"];
									$salesorderitem->shipping = $orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["ActualShippingCost"];
									$salesorderitem->tax = $orders["OrderArray"]["Order"][$i]["TransactionArray"]["Transaction"]["Taxes"]["TotalTaxAmount"];
							        $salesorderitem->save();
								}
								catch (Exception $e) {
									continue;
								}

							}

						}
					}
					else
					{
						//var_dump($orders);
						/*

						preg_match("/\[(.*)\]/s",$orders["Order"]["TransactionArray"]["Transaction"]["Item"]["Title"], $output);
							$orders_imported += count($orders);
							$sku = null;

							if($output !=null)
							{
								$sku = (string)$output[1];
							}

							if ( $sku != null)
							{
								try {

									$salesorder = new SalesOrder;
									$salesorder->seller_id = $seller->id;
						            $salesorder->purchase_date = date('Y-m-d H:i:s', strtotime($orders["Order"]["CreatedTime"]));
						            $salesorder->order_id = $orders["Order"]["OrderID"];
						            $salesorder->email = $orders["Order"]["TransactionArray"]["Transaction"]["Buyer"]["Email"];
						            $salesorder->buyer_name = $orders["Order"]["ShippingAddress"]["Name"];
						            $salesorder->ship_address1 = $orders["Order"]["ShippingAddress"]["Street1"];
						            //$salesorder->ship_address2 = $orders["Order"]["ShippingAddress"]["Street2"];
						            $salesorder->ship_city = $orders["Order"]["ShippingAddress"]["CityName"];
						            $salesorder->ship_state = $orders["Order"]["ShippingAddress"]["StateOrProvince"];
						            $salesorder->ship_zip = $orders["Order"]["ShippingAddress"]["PostalCode"];
						            $salesorder->ship_phone = $orders["Order"]["ShippingAddress"]["Phone"];
						            $salesorder->purchase_source = 'ebay';
						            $salesorder->save();

						            $salesorderitem = new SalesOrderItem;
									$salesorderitem->so_id = $salesorder->id;
									$salesorderitem->aid = $sku;
									$salesorderitem->quantity = $orders["Order"]["TransactionArray"]["Transaction"]["QuantityPurchased"];
									$salesorderitem->cost_per_item = $orders["Order"]["TransactionArray"]["Transaction"]["TransactionPrice"];
									$salesorderitem->total = $orders["Order"]["AmountPaid"];
									$salesorderitem->shipping = $orders["Order"]["TransactionArray"]["Transaction"]["ActualShippingCost"];
									$salesorderitem->tax = $orders["Order"]["TransactionArray"]["Transaction"]["Taxes"]["TotalTaxAmount"];
							        $salesorderitem->save();
						        }
								catch (Exception $e) {
									continue;
								}

							} */
					}

					}

					} // End of Ebay

			// Grab Amazon API Credentials
				$amazons = DB::select("SELECT * FROM user_api_profiles WHERE seller_id = $seller->id AND provider = 'amazon'");

				foreach ($amazons as $amazon) {

					//$date = $last_pull;
					$date = '2015-01-27T15:44:53Z';
					$merchant_id = $amazon->api_cred1;
					$marketplace_id = $amazon->api_cred2;
					$aws_id = $amazon->api_cred3;
					$aws_key = $amazon->api_cred4;

					$amazon_api = new AmazonApi();

					$orders = $amazon_api->amazonOrders($date, $merchant_id, $marketplace_id, $aws_id, $aws_key);

					echo "<h1>AMAZON PULL</h1>";


					if ($orders != null)
					{

					if (!array_key_exists('0', $orders))
					{
						$orders_imported += count($orders["AmazonOrderId"]);

						$order = $orders;

						try {
							$convert = new ShipInfo();
            				$abv = $convert->stateAbbrev($order["ShippingAddress"]["StateOrRegion"]);

							$salesorder = new SalesOrder;
							$salesorder->seller_id = $seller->id;
				            $salesorder->purchase_date = date('Y-m-d H:i:s', strtotime($order["PurchaseDate"]));
				            $salesorder->order_id = $order["AmazonOrderId"];
				            $salesorder->email = $order["BuyerEmail"];
				            $salesorder->buyer_name = $order["BuyerName"];
				            $salesorder->ship_address1 = $order["ShippingAddress"]["AddressLine1"];

				            if (array_key_exists('AddressLine2', $order["ShippingAddress"]))
					        {
						        $salesorder->ship_address2 = $order["ShippingAddress"]["AddressLine2"];
						    }

				            $salesorder->ship_city = $order["ShippingAddress"]["City"];
				            $salesorder->ship_state = $abv;
				            $salesorder->ship_zip = $order["ShippingAddress"]["PostalCode"];

				            if (array_key_exists('Phone', $order["ShippingAddress"]))
				            {
				            	$salesorder->ship_phone = $order["ShippingAddress"]["Phone"];
				            }

				            $salesorder->purchase_source = 'amazon';
				            $salesorder->save();


							$items = $amazon_api->amazonOrderItems($order['AmazonOrderId'], $merchant_id, $marketplace_id, $aws_id, $aws_key);
							var_dump($items);
							if ($items["OrderItemId"] != null)
								{
									$asin = (string)$items['ASIN'];
									$getsku = DB::select("SELECT DISTINCT(products.sku) AS sku FROM virtual_products LEFT JOIN virtual_product_items ON ( virtual_product_items.vp_id = virtual_products.id ) LEFT JOIN products ON ( products.aid = virtual_product_items.aid ) WHERE virtual_products.asin = '$asin'");
									$skuarray = json_decode(json_encode($getsku), true);
									$sku = $skuarray[0]['sku'];

									$qty = count($getsku) * $items["QuantityOrdered"];

									$salesorderitem = new SalesOrderItem;
									$salesorderitem->so_id = $salesorder->id;
									$salesorderitem->aid = $sku;
									$salesorderitem->quantity = $qty;
									$salesorderitem->cost_per_item = $items["ItemPrice"]["Amount"];
									$salesorderitem->total = $items["ItemPrice"]["Amount"];
									$salesorderitem->shipping = $items["ShippingPrice"]["Amount"];
									$salesorderitem->tax = $items["ItemTax"]["Amount"];
				            		$salesorderitem->save();

				            	}
				        }
						catch (Exception $e) {
							continue;
						}

					}
					else
					{
						$orders_imported += count($orders);

						//						var_dump($orders);

						foreach ($orders as $order)
						{
							try {
								$convert = new ShipInfo();
            					$abv = $convert->stateAbbrev($order["ShippingAddress"]["StateOrRegion"]);

								$salesorder = new SalesOrder;
								$salesorder->seller_id = $seller->id;
						    	$salesorder->purchase_date = date('Y-m-d H:i:s', strtotime($order["PurchaseDate"]));
						        $salesorder->order_id = $order["AmazonOrderId"];
						        $salesorder->email = $order["BuyerEmail"];
						        $salesorder->buyer_name = $order["BuyerName"];
						        $salesorder->ship_address1 = $order["ShippingAddress"]["AddressLine1"];

						        if (array_key_exists('AddressLine2', $order["ShippingAddress"]))
					            {
						        	$salesorder->ship_address2 = $order["ShippingAddress"]["AddressLine2"];
						    	}

						        $salesorder->ship_city = $order["ShippingAddress"]["City"];
						        $salesorder->ship_state = $abv;
						        $salesorder->ship_zip = $order["ShippingAddress"]["PostalCode"];

						        if (array_key_exists('Phone', $order["ShippingAddress"]))
					            {
					            	$salesorder->ship_phone = $order["ShippingAddress"]["Phone"];
					            }

						        $salesorder->purchase_source = 'amazon';
						        $salesorder->save();


								$items = $amazon_api->amazonOrderItems($order['AmazonOrderId'], $merchant_id, $marketplace_id, $aws_id, $aws_key);

								echo '<h4>Items</h4>';
								//var_dump($items);

									if ($items["OrderItemId"] != null)
									{
										$asin = (string)$items['ASIN'];
										$getsku = DB::select("SELECT DISTINCT(products.sku) AS sku FROM virtual_products LEFT JOIN virtual_product_items ON ( virtual_product_items.vp_id = virtual_products.id ) LEFT JOIN products ON ( products.aid = virtual_product_items.aid ) WHERE virtual_products.asin = '$asin'");
										$skuarray = json_decode(json_encode($getsku), true);
										$sku = $skuarray[0]['sku'];

										$qty = count($getsku) * $items["QuantityOrdered"];

										$salesorderitem = new SalesOrderItem;
										$salesorderitem->so_id = $salesorder->id;
										$salesorderitem->aid = $sku;
										$salesorderitem->quantity = $qty;
										$salesorderitem->cost_per_item = $items["ItemPrice"]["Amount"];
										$salesorderitem->total = $items["ItemPrice"]["Amount"];
										$salesorderitem->shipping = $items["ShippingPrice"]["Amount"];
										$salesorderitem->tax = $items["ItemTax"]["Amount"];
						            	$salesorderitem->save();

						            }
							}
							catch (Exception $e) {
								continue;
							}

							}
						}
					}
				} // End of Amazon

			// Write Pull Request to DB for Last Pull
				$api_pull = new UserApiRequest;
				$api_pull->seller_id = $seller->id;
				$api_pull->pull_datetime = $current_date;
				$api_pull->save();

			} // Seller End

			echo "<h4>Sales Pull Complete</h4><b>Imported $orders_imported orders $current_date</b>";

		} // App End
	}
}
