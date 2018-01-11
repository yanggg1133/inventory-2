<?php

define ("API_ENDPOINT", "https://api.ebay.com/ws/api.dll");
define ("DEVID", "43800b8f-2c44-4e10-a462-006a10cbc6aa");
define ("AppID", "SocialMe-5009-40cc-82b1-d4f0515deb7e");
define ("CertID", "d4707af9-2ab6-4f41-b8dd-bfd6599f1847");
define ("RuName", "SocialMedia_Des-SocialMe-5009-4-fxsno");

class EbayApi {
	
	function ebayOrders($auth_token, $last_pull, $current_date)
	{

		$feed = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
		        <GetOrdersRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
		        <RequesterCredentials>
		        <eBayAuthToken>$auth_token</eBayAuthToken>
		        </RequesterCredentials>
		        <CreateTimeFrom>$last_pull</CreateTimeFrom>
		        <CreateTimeTo>$current_date</CreateTimeTo>
		        <OrderStatus>Completed</OrderStatus>
		        </GetOrdersRequest>​";

		        $feed = trim($feed);

		$headers = array(
		        'X-EBAY-API-COMPATIBILITY-LEVEL: 879',
		        'X-EBAY-API-DEV-NAME: '.DEVID,
		        'X-EBAY-API-APP-NAME: '.AppID,
		        'X-EBAY-API-CERT-NAME: '.CertID,
		        'X-EBAY-API-SITEID: 0',
		        'X-EBAY-API-CALL-NAME: GetOrders',
		    );


		$connection = curl_init();
		curl_setopt($connection, CURLOPT_URL, API_ENDPOINT);
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($connection, CURLOPT_POST, 1);
		curl_setopt($connection, CURLOPT_POSTFIELDS, $feed);
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($connection);

		curl_close($connection);

		$json_response = json_decode(json_encode((array)simplexml_load_string($response)),1);

		return $json_response;
	}

	function ebayShipments($auth_token, $item_id, $tracking_num) 
	{
		$feed = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<CompleteSaleRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
				  <RequesterCredentials>
				    <eBayAuthToken></eBayAuthToken>
				  </RequesterCredentials>
				  <WarningLevel>High</WarningLevel>
				  <ItemID>$item_id</ItemID>
				  <Shipment>
				    <ShipmentTrackingDetails>
				      <ShipmentTrackingNumber>$tracking_num</ShipmentTrackingNumber>
				      <ShippingCarrierUsed>UPS</ShippingCarrierUsed>
				    </ShipmentTrackingDetails>
				  </Shipment>
				  <Shipped>true</Shipped>
				  <TransactionID>0</TransactionID>
				</CompleteSaleRequest>";

		        $feed = trim($feed);

		$headers = array(
		        'X-EBAY-API-COMPATIBILITY-LEVEL: 903',
		        'X-EBAY-API-DEV-NAME: '.DEVID,
		        'X-EBAY-API-APP-NAME: '.AppID,
		        'X-EBAY-API-CERT-NAME: '.CertID,
		        'X-EBAY-API-SITEID: 0',
		        'X-EBAY-API-CALL-NAME: CompleteSale',
		    );


		$connection = curl_init();
		curl_setopt($connection, CURLOPT_URL, API_ENDPOINT);
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($connection, CURLOPT_POST, 1);
		curl_setopt($connection, CURLOPT_POSTFIELDS, $feed);
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($connection);

		curl_close($connection);
	}
}