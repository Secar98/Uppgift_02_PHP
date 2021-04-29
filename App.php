<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
$response = file_get_contents('Data.json');
$data = json_decode($response, true);

$categorys = array("jewelery", "men clothing", "women clothing", "electronics");

if (!isset($_GET['show']) && !isset($_GET['category'])) {
    $amount = 20;
    $category = "all";
    echo $amount . $category;
} elseif (check_category($_GET['category'] ?? null, $categorys) || validate_show_is_number($_GET['show'] ?? null)) {
    $amount = $_GET['show'] ?? null;
    $category = $_GET['category'] ?? null;
    echo $amount . $category;
} else {
    echo "FEEL";
}

function validate_show_is_number($show)
{
    $check_if_number = filter_var($show, FILTER_VALIDATE_INT);
    return $check_if_number;
}
function check_category($category, $categorys)
{
    $check_category = in_array($category, $categorys);
    return $check_category;
}
