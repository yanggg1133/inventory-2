<?php

class CscartApi {

	function cscartOrders($auth_user, $auth_pass)
		{
			$params = array(
				'status' => 'P',
			);

	        // Sort the URL parameters
	        $url_parts = array();
	        foreach(array_keys($params) as $key)
	            $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
	        sort($url_parts);

	        // Construct the string to sign
	        $url_string = implode("&", $url_parts);

	        $url = "http://www.trailertiresupercenter.com/api/orders/?status=P";

	        $header = array("Authorization: Basic " . base64_encode($auth_user . ":" . $auth_pass));

	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	        $response = json_decode(curl_exec($ch), true);
	        $results = (array)$response;
	        return $results;
    }

    function cscartSingleOrders($auth_user, $auth_pass, $order_id)
		{
	        $url = "http://www.trailertiresupercenter.com/api/orders/$order_id";

	        $header = array("Authorization: Basic " . base64_encode($auth_user . ":" . $auth_pass));

	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($ch, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	        $response = json_decode(curl_exec($ch), true);
	        $results = (array)$response;
	        return $results;
    }
}