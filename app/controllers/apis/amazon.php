<?php

class AmazonApi
{
    public function amazonRequest($params, $aws_key)
    {

            // Sort the URL parameters
            $url_parts = array();
        foreach (array_keys($params) as $key) {
            $url_parts[] = $key.'='.str_replace('%7E', '~', rawurlencode($params[$key]));
        }
        sort($url_parts);

            // Construct the string to sign
            $url_string = implode('&', $url_parts);
        $string_to_sign = "GET\nmws.amazonservices.com\n/Orders/2013-09-01\n".$url_string;

            // Sign the request
            $signature = hash_hmac('sha256', $string_to_sign, $aws_key, true);

            // Base64 encode the signature and make it URL safe
            $signature = urlencode(base64_encode($signature));

        $url = 'https://mws.amazonservices.com/Orders/2013-09-01'.'?'.$url_string.'&Signature='.$signature;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);

        $json_response = json_decode(json_encode((array) simplexml_load_string($response)), 1);

        return $json_response;
    }

    public function amazonOrders($date, $merchant_id, $marketplace_id, $aws_id, $aws_key)
    {
        //$date = '2015-12-10T15:44:53Z';
            // Call Orders
            $params = array(
                'AWSAccessKeyId' => $aws_id,
                'Action' => 'ListOrders',
                'SellerId' => $merchant_id,
                'SignatureVersion' => '2',
                'Timestamp' => date("Y-m-d\TH:i:s\\Z", time()),
                'Version' => '2013-09-01',
                'SignatureMethod' => 'HmacSHA256',
                'LastUpdatedAfter' => $date,
                'MarketplaceId.Id.1' => $marketplace_id,
                'OrderStatus.Status.1' => 'Unshipped',
                'OrderStatus.Status.2' => 'PartiallyShipped',

                //'OrderStatus.Status.3' => "Shipped",
            );

        $orders = $this->amazonRequest($params, $aws_key);
        if (array_key_exists('Order', $orders['ListOrdersResult']['Orders'])) {
            return $orders['ListOrdersResult']['Orders']['Order'];
                //return $orders;
        }
    }

    public function amazonOrderItems($order_id, $merchant_id, $marketplace_id, $aws_id, $aws_key)
    {
        // Call Order Items
            $params = array(
                'AWSAccessKeyId' => $aws_id,
                'Action' => 'ListOrderItems',
                'SellerId' => $merchant_id,
                'AmazonOrderId' => $order_id,
                'SignatureVersion' => '2',
                'SignatureMethod' => 'HmacSHA256',
                'Timestamp' => date("Y-m-d\TH:i:s\\Z", time()),
                'Version' => '2013-09-01',
            );

        $items = $this->amazonRequest($params, $aws_key);

        if (array_key_exists('ListOrderItemsResult', $items)) {
            return $items['ListOrderItemsResult']['OrderItems']['OrderItem'];
        }
    }

    public function amazonOrderUpdates($order_id, $merchant_id, $marketplace_id, $aws_id, $aws_key)
    {
        // Call Order Items
            $params = array(
                'Action' => 'GetOrder',
                'AWSAccessKeyId' => $aws_id,
                'SellerId' => $merchant_id,
                'AmazonOrderId.Id.1' => $order_id,
                'SignatureVersion' => '2',
                'SignatureMethod' => 'HmacSHA256',
                'Timestamp' => date("Y-m-d\TH:i:s\\Z", time()),
                'Version' => '2013-09-01',
            );

        $updates = $this->amazonRequest($params, $aws_key);

        return $updates['GetOrderResult']['Orders']['Order'];
	}
}
