<?php

require ("Product.php");
class ProductType
{
    public static function createProduct($data)
    {
        // Extract product type from data
        $type = $data['type'];

        // Determine the appropriate class name based on product type
        $className = ucfirst(strtolower($type));

        // Check if the class exists
        if (class_exists($className)) {
            // Create and return an instance of the appropriate class
            return new $className($data['sku'], $data['name'], $data['price'], $data);
        } else {
            throw new Exception("Invalid product type: {$type}");
        }
    }
}