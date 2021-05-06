<?php
class Validation
{
    /**
     * Method to chek if a value is numeric
     */
    public static function validate_is_number($value)
    {
        return is_numeric($value);
    }

    /**
     * Method to check if value is the right amount  
     */
    public static function validate_amount($value)
    {
        return ($value >= 1 && $value <= 20);
    }

    /**
     * Method to check if category is valid
     */
    public static function validate_category($category, $categorys)
    {
        return in_array($category, $categorys);
    }
}
