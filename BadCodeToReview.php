<?php

class OrderService
{
    private PromoCodeDiscounter $service;

    public function __construct(PromoCodeDiscounter $service)
    {
        $this->service = $service;
    }

    public function getProductPrice(array $product, ?string $promoCode = null)
    {
        $productType = null;
        switch ($product['type']) {
            case $product['type'] == 1:
                $productType = new Pizza($product);

                break;
            case $product['type'] == 2:
                $productType = new Sushi($product);

                break;
            default:
                throw new Error('Can\'t find any product!');
        }

        return $this->service->applyPromoCode($productType->getPrice(), $promoCode);
    }
}

class MenuFood
{
    public $name;

    public $price;

    public function getPrice()
    {
        return $this->price;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Pizza extends MenuFood
{
}

class Sushi extends MenuFood
{
    public const DISCOUNT = 20;

    public function __construct($product)
    {
        $this->name = $product['title_from_1c'];
        $this->price = $product['price'];
    }

    public function getPrice()
    {
        if ($this->price <= 0) {
            throw new Exception('Price can\'t be less or equal zero!');
        }

        return $this->price * self::DISCOUNT / 100;
    }
}

interface DiscounterInterface
{
    public function applyPromoCode($price, $promoCode);

    public function getAllPromoCodes();
}

class PromoCodeDiscounter implements DiscounterInterface
{
    public function applyPromoCode($price, $promoCode)
    {
        $discount = 1; //Let's imagine that we get it from DB for example by promoCode

        return $price * $discount;
    }

    public function getAllPromoCodes()
    {
        throw new Exception('Method is not used in this class!');
    }
}