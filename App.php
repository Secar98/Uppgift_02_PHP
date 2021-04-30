<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
$response = file_get_contents('Data.json');
$data = json_decode($response, true);

$categorys = array("all", "jewelery", "men clothing", "women clothing", "electronics");
$errorsArray = [];

$amount = isset($_GET['show']) ? $_GET['show'] : 20;
$category = isset($_GET['category']) ? $_GET['category'] : "all";


validate_is_between($amount) === 0 ? array_push($errorsArray, "Show must be a Number and between 1 - 20") : true;
check_category($category, $categorys) ? true : array_push($errorsArray, "Not valid category!");

if ($errorsArray) {
    print_r($errorsArray);
    exit();
}

function validate_is_between($value)
{
    $result = ($value >= 1 && $value <= 20) ? true : 0;
    return $result;
}

function check_category($category, $categorys)
{
    $result2 = in_array($category, $categorys);
    return $result2;
}



//validate_is_number($amount) ? array_push($errorsArray, "Must be a number!") : true;
/*function validate_is_number($value)
{
    $result = filter_var($value, FILTER_VALIDATE_INT);
    //echo $result;
    return $result;
}*/