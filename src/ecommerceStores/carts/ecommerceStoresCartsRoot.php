<?php

class Ecommerce_Store_Carts extends Ecommerce_Stores
{

    public $grandchild_resource;

    //SUBCLASS INSTANTIATIONS
    public $lines;

    function __construct($apikey, $parent_resource, $class_input)
    {
        parent::__construct($apikey, $parent_resource);
        if (isset($class_input)) {
            $this->url .= '/carts/' . $class_input;
        } else {
            $this->url .= '/carts/';
        }

        $this->grandchild_resource = $class_input;
    }

    public function POST(
        $cartid,
        $customer = array(),
        $currency_code,
        $order_total,
        $lines,
        $optional_parameters = array()
    ) {
        $params = array("id" => $cartid,
            "customer" => $customer,
            "currency_code" => $currency_code,
            "order_total" => $order_total,
            "lines" => $lines);

        $params = array_merge($params, $optional_parameters);

        $payload = json_encode($params);
        $url = $this->url;

        $response = $this->curlPost($url, $payload);

        return $response;
    }

    public function GET( $query_params = null )
    {

        $query_string = '';

        if (is_array($query_params)) {
            $query_string = $this->constructQueryParams($query_params);
        }

        $url = $this->url . $query_string;
        $response = $this->curlGet($url);

        return $response;

    }

    public function PATCH( $patch_params =  array() )
    {
        $payload = json_encode($patch_params);
        $url = $this->url;

        $response = $this->curlPatch($url, $payload);

        return $response;
    }

    public function DELETE()
    {
        $url = $this->url;
        $response = $this->curlDelete($url);

        return $response;
    }

    //SUBCLASS FUNCTIONS ------------------------------------------------------------

    public function lines( $class_input = null )
    {
        $this->lines = new Ecommerce_Stores_Cart_Lines(
            $this->apikey,
            $this->subclass_resource,
            $this->grandchild_resource,
            $class_input
        );
        return $this->lines;
    }

} 