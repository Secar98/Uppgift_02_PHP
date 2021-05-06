<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
require_once "validation.php";
class API
{
    /**
     * Statiska variabler 
     */
    private static $categorys = array("all", "jewelery", "men clothing", "women clothing", "electronics");
    private static $errorsArray = array();
    private static $products = array();

    /**
     * Main metod
     */
    public static function main($show, $category)
    {
        // validates that the user input is correct otherwise return error message
        if (!Validation::validate_is_number($show))
            array_push(self::$errorsArray, "Show must be a Number!");
        if (!Validation::validate_amount($show))
            array_push(self::$errorsArray, "Show must be between 1 - 20");
        if (!Validation::validate_category($category, self::$categorys))
            array_push(self::$errorsArray, "Not valid category!");

        // if there are any error display them to user
        if (self::$errorsArray) {
            $errors = json_encode(self::$errorsArray, JSON_UNESCAPED_UNICODE);
            echo $errors;
            exit();
        }

        // gets all the products and filter them depending on what the user has inputed
        self::$products = self::get_products();
        self::$products = $category === 'all' ? self::$products : self::filter_category(self::$products, $category);
        self::$products = self::limit_products(self::$products, $show);

        // encodes the products array so it can  be returned as JSON
        $data = json_encode(self::$products, JSON_UNESCAPED_UNICODE);
        echo $data;
    }

    /**
     * Gets the products from the Data.json file
     */
    private static function get_products()
    {
        $response = file_get_contents('Data.json');
        return json_decode($response, true);
    }

    /**
     * Filters the desierd category
     */
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

    /**
     * Limits the amount of products
     */
    private static function limit_products($products, $amount)
    {
        shuffle($products);
        return array_splice($products, -20, $amount);
    }
}

// checks if user has asigned show or category a value, otherwise variabels are set to the default  
$show = isset($_GET['show']) ? htmlspecialchars($_GET['show']) : 20;
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : "all";

// runs main method of the class API
API::main($show, $category);
