<?php
require_once "utils.php";
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
class API
{
    private static $categorys = array("all", "jewelery", "men clothing", "women clothing", "electronics");
    private static $errorsArray = array();
    private static $products = array();

    public static function main($amount, $category)
    {
        if (!Validation::validate_is_number($amount))
            array_push(self::$errorsArray, "Show must be a Number!");
        if (!Validation::validate_amount($amount))
            array_push(self::$errorsArray, "Show must be between 1 - 20");
        if (!Validation::validate_category($category, self::$categorys))
            array_push(self::$errorsArray, "Not valid category!");

        if (self::$errorsArray) {
            $errors = json_encode(self::$errorsArray);
            echo $errors;
            exit();
        }

        self::$products = self::get_products();
        self::$products = $category === 'all' ? self::$products : self::filter_category(self::$products, $category);
        self::$products = self::limit_products(self::$products, $amount);

        $data = json_encode(self::$products);
        echo $data;
    }

    private static function get_products()
    {
        $response = file_get_contents('Data.json');
        $data = json_decode($response, true);
        return $data;
    }

    private static function filter_category($products, $category)
    {
        $filterdProducts = array();
        foreach ($products as $value) {
            if ($value['category'] === $category) {
                array_push($filterdProducts, $value);
            }
        }
        return $filterdProducts;
    }

    private static function limit_products($products, $amount)
    {
        shuffle($products);
        return array_splice($products, -20, $amount);
    }
}

$amount = isset($_GET['show']) ? htmlspecialchars($_GET['show']) : 20;
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : "all";

API::main($amount, $category);
