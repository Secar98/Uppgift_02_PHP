<?php
class Validation
{
    public static function validate_is_number($value)
    {
        $result = is_numeric($value);
        return $result;
    }

    public static function validate_amount($value)
    {
        $result = ($value >= 1 && $value <= 20);
        return $result;
    }

    public static function validate_category($category, $categorys)
    {
        $result = in_array($category, $categorys);
        return $result;
    }
}
