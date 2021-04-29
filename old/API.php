<?php
require_once "product.php";
class API
{
    public function main()
    {
        if ($this->validateShow()) {
            $amount = htmlspecialchars($_GET['show']);
            $products = $this->generateProducts($amount,);
            print_r($products);
        } elseif (!isset($_GET['show'])) {
            $products = $this->generateProducts(20);
            print_r($products);
        } else {
            echo "NEEEEJ";
        }
    }
    private function generateProducts($amount)
    {
        $products = array();
        for ($i = 1; $i <= $amount; $i++) {

            $categoryArray = array("jewelery", "men clothing", "women clothing", "electronics");
            $randomCategory = array_rand(array_flip($categoryArray), 1);

            $randPicture = "https://picsum.photos/500?random=$i";
            $price = rand(10, 999);
            $product = new Product($i, "Hej", $randPicture, $price, $randomCategory, "lorem ipsum");
            array_push($products, $product->toArray());
        }
        return $products;
    }
    private function validateShow()
    {
        if (isset($_GET['show'])) {
            if (filter_var($_GET['show'], FILTER_VALIDATE_INT)) {
                return true;
            } elseif (!isset($_GET['show'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    private function validateCategory()
    {
        if (isset($_GET['category']) && $_GET['category'] === "jewelery" || "men clothing" || "women clothing" || "electronics") {
            return true;
        } elseif (!isset($_GET['category'])) {
            return true;
        } else {
            return false;
        }
    }
}
$app = new API();
$app->main();
