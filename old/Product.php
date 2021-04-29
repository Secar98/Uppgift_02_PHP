<?php
class Product
{
    private $id;
    private $title;
    private $image;
    private $price;
    private $text;

    public function __construct($id, $title, $image, $price, $category, $text)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->price = $price;
        $this->category = $category;
        $this->text = $text;
    }
    public function toArray()
    {
        $array = array(
            "id" => $this->id,
            "title" => $this->title,
            "image" => $this->image,
            "price" => $this->price,
            "category" => $this->category,
            "text" => $this->text
        );

        return $array;
    }
}
