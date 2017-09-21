<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 20/09/2017
 * Time: 14:26
 */

namespace App\Discounts;

use App\Order;
use App\Product;

class SwitchesDiscount implements Discount {

    /**
     * @var float
     */
    private $discount = 0.0;

    /**
     * @var int
     */
    private $switchesInTheOrder;

    /**
     * Returns the order in wich the discount run in comparison to other discounts
     *
     * Starting from 0
     *
     * @return int
     */
    public static function getRunOrder(): int {
        return 1;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return self::TYPE_PERCENTAGE;
    }

    /**
     * @return float
     */
    public function getDiscount(): array {
        return [
            'total' => $this->discount,
            'switches' => $this->switchesInTheOrder,
            'description' => 'For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.'
        ];
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function calculateDiscount(Order $order): float {
        $unitPrice = 0;
        $this->switchesInTheOrder = $order->countProductsByCategory(Product::CATEGORY_SWITCHES );

        $freeSwitches = $this->freeSwitches( $this->switchesInTheOrder );

        $items = $order->items;

        foreach ( $items as $item ) {
            $product = $item->product;
            if ( $product->category == Product::CATEGORY_SWITCHES ) {
                $unitPrice = $product->price;
            }
        }

        return $this->discount = $freeSwitches * $unitPrice;
    }

    /**
     * Returns the quantity of free switches in the order
     *
     * @param $total
     * @param int $freeSwitches
     *
     * @return int
     */
    private function freeSwitches( $total, $freeSwitches = 0 ) {

        if ( ( $total - 6 ) >= 0 ) {
            $freeSwitches ++;

            return $this->freeSwitches( $total - 6, $freeSwitches );
        }

        return $freeSwitches;
    }
}