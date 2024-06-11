<?php
abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price)
    {
        $this->setSKU($sku);
        $this->setName($name);
        $this->setPrice($price);
    }

    // Setters
    public function setSKU($sku)
    {
        $this->sku = $sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    { 
        $this->price = $price;
    }

    // Getters
    public function getSKU()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    // Abstract method for displaying product-specific attribute
    abstract public function displayAttribute();
}

// DVD.php
class DVD extends Product
{
    protected $size;

    public function __construct($sku, $name, $price, $data)
    {
        parent::__construct($sku, $name, $price);
        $this->setSize($data['size']);
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function displayAttribute()
    {
        return "Size: {$this->getSize()} MB";
    }
}

//Book.php
class Book extends Product
{
    protected $weight;

    public function __construct($sku, $name, $price, $data)
    {
        parent::__construct($sku, $name, $price);
        $this->setWeight($data['weight']);
    }

    public function setWeight($weight)
    {   
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function displayAttribute()
    {
        return "Weight: {$this->getWeight()} Kg";
    }
}

// Furniture.php
class Furniture extends Product
{
    protected $dimensions;

    public function __construct($sku, $name, $price, $data)
    {
        parent::__construct($sku, $name, $price);
        $this->setDimensions($data['dimensions']);
    }

    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function getDimensions()
    {
        return $this->dimensions;
    }

    public function displayAttribute()
    {
        return "Dimensions: {$this->getDimensions()}";
    }
}