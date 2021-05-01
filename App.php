<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");

$response = file_get_contents('Data.json');
$data = json_decode($response, true);

$categorys = array("all", "jewelery", "men clothing", "women clothing", "electronics");
$errorsArray = array();

$amount = isset($_GET['show']) ? $_GET['show'] : 20;
$category = isset($_GET['category']) ? $_GET['category'] : "all";


validate_show_is_number($amount) ? true : array_push($errorsArray, "Show must be a Number!");
validate_show($amount) ? true : array_push($errorsArray, "Show must be between 1 - 20");
validate_category($category, $categorys) ? true : array_push($errorsArray, "Not valid category!");

if ($errorsArray) {
    $errors = json_encode($errorsArray);
    echo $errors;
    exit();
}

$products = $category === 'all' ? $data : filter_category($data, $category);
$products = limit_products($products, $amount);

$data = json_encode($products);
echo $data;


function filter_category($data, $category)
{
    $products = array();
    foreach ($data as $value) {
        if ($value['category'] === $category) {
            array_push($products, $value);
        }
    }
    return $products;
}
function limit_products($products, $amount)
{
    shuffle($products);
    return array_splice($products, -20, $amount);
}
function validate_show_is_number($value)
{
    $result = is_numeric($value) ? true : false;
    return $result;
}
function validate_show($value)
{
    $result = ($value >= 1 && $value <= 20) ? true : false;
    return $result;
}
function validate_category($category, $categorys)
{
    $result2 = in_array($category, $categorys);
    return $result2;
}
