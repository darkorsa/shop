<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

use Money\Money;
use Plane\Shop\Validator\QuantityValidatorInterface;
use Plane\Shop\Exception\QuanityException;

class CartItem implements CartItemInterface
{
    private $product;

    private $quantityValidator;

    private $quantity;

    public function __construct(
        ProductInterface $product,
        $quantity = 1,
        QuantityValidatorInterface $quantityValidator = null
    ) {
        $this->product = $product;
        $this->quantityValidator = $quantityValidator;
        $this->setQuantity((int) $quantity);
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getId(): string
    {
        return $this->product->getId();
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getImagePath(): string
    {
        return $this->product->getImagePath();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        if (!$this->validateQuantity($quantity)) {
            throw new QuanityException('Invalid quantity: ' . $quantity);
        }

        $this->quantity = $quantity;
    }

    public function increaseQuantity(int $quantity): void
    {
        $newQuantity = $this->quantity + $quantity;

        $this->setQuantity($newQuantity);
    }

    public function decreaseQuantity(int $quantity): void
    {
        $newQuantity = $this->quantity - $quantity;

        $this->setQuantity($newQuantity);
    }

    public function getWeight(): float
    {
        return $this->product->getWeight();
    }

    public function getWeightTotal(): float
    {
        return (float) bcmul((string) $this->getWeight(), (string) $this->quantity, 2);
    }

    public function getTax(string $currency): Money
    {
        return $this->product->getTax($currency);
    }

    public function getTaxTotal(string $currency): Money
    {
        return $this->getTax($currency)->multiply($this->quantity);
    }

    public function getPrice(string $currency): Money
    {
        return $this->product->getPrice($currency);
    }

    public function getPriceTotal(string $currency): Money
    {
        return $this->getPrice($currency)->multiply($this->quantity);
    }

    public function getPriceWithTax(string $currency): Money
    {
        return $this->product->getPriceWithTax($currency);
    }

    public function getPriceTotalWithTax(string $currency): Money
    {
        return $this->getPriceTotal($currency)->add($this->getTaxTotal($currency));
    }

    public function toArray(string $currency): array
    {
        $array = [];
        $array['quantity']          = $this->getQuantity();
        $array['totalTax']          = $this->getTaxTotal($currency);
        $array['priceTotal']        = $this->getPriceTotal($currency);
        $array['priceTotalWithTax'] = $this->getPriceTotalWithTax($currency);
        $array['product']           = $this->product->toArray($currency);

        return $array;
    }

    private function validateQuantity(int $quantity): bool
    {
        if ($this->quantityValidator === null) {
            return $quantity >= 1;
        }

        return $this->quantityValidator->validate($this->product, $quantity);
    }
}
