<?php

date_default_timezone_set("UTC");

include app_path()."/controllers/apis/amazon.php";

class AmazonUpdateController extends \BaseController {

	function orderUpdates()
	{

				// Grab Amazon API Credentials
				$amazons = DB::select("SELECT * FROM user_api_profiles WHERE seller_id = 1 AND provider = 'amazon'");

				foreach ($amazons as $amazon) {

					//$date = $last_pull;
					$date = '2016-03-02T15:44:53Z';
					$merchant_id = $amazon->api_cred1;
					$marketplace_id = $amazon->api_cred2;
					$aws_id = $amazon->api_cred3;
					$aws_key = $amazon->api_cred4;

					$amazon_api = new AmazonApi();

					$orders = DB::select("SELECT id, order_id FROM sales_orders WHERE purchase_date BETWEEN '2015-03-03 00:00:00' '2016-03-10 00:00:00'AND purchase_source = 'amazon'");


					foreach ($orders as $order) {

						$getUpdates = $amazon_api->amazonOrderUpdates($order->order_id, $merchant_id, $marketplace_id, $aws_id, $aws_key);

						$search = array();
						$cleanDate = str_replace($search, " ", $getUpdates["LastUpdateDate"]);

						$date = date_create($cleanDate);
						$newDate = date_format($date, 'Y-m-d H:i:s');

						$amzOrder = SalesOrder::find($order->id);
		                $amzOrder->amazon_update = $newDate;
		                $amzOrder->save();

					}


				}



	}
}
