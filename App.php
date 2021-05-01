<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
class API
{
    private $categorys = array("all", "jewelery", "men clothing", "women clothing", "electronics");
    private $errorsArray = array();
    private $products;

    public function main($amount, $category)
    {
        $this->validate_show_is_number($amount) ? true : array_push($this->errorsArray, "Show must be a Number!");
        $this->validate_show($amount) ? true : array_push($this->errorsArray, "Show must be between 1 - 20");
        $this->validate_category($category) ? true : array_push($this->errorsArray, "Not valid category!");

        if ($this->errorsArray) {
            $errors = json_encode($this->errorsArray);
            echo $errors;
            exit();
        }

        $this->products = $this->get_products();
        $this->products = $category === 'all' ? $this->products : $this->filter_category($this->products, $category);
        $this->products = $this->limit_products($this->products, $amount);

        $data = json_encode($this->products);
        echo $data;
    }

    private function get_products()
    {
        $response = file_get_contents('Data.json');
        $data = json_decode($response, true);
        return $data;
    }

    private function filter_category($products, $category)
    {
        $filterdProducts = array();
        foreach ($products as $value) {
            if ($value['category'] === $category) {
                array_push($filterdProducts, $value);
            }
        }
        return $filterdProducts;
    }

    private function limit_products($products, $amount)
    {
        shuffle($products);
        return array_splice($products, -20, $amount);
    }

    private function validate_show_is_number($value)
    {
        $result = is_numeric($value) ? true : false;
        return $result;
    }

    private function validate_show($value)
    {
        $result = ($value >= 1 && $value <= 20) ? true : false;
        return $result;
    }

    private function validate_category($category)
    {
        $result = in_array($category, $this->categorys);
        return $result;
    }
}

$amount = isset($_GET['show']) ? $_GET['show'] : 20;
$category = isset($_GET['category']) ? $_GET['category'] : "all";

$api = new API();
$api->main($amount, $category);
