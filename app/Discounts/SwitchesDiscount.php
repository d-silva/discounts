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
     * @return string
     */
    public function getType(): string {
        return self::TYPE_PERCENTAGE;
    }

    /**
     * @return float
     */
    public function getDescription(): string {
        return 'For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    }

    /**
     * Calculate and creates the Discount
     *
     * @param Order $order
     */
    public function calculateDiscount( Order $order) {
        $unitPrice     = 0;
        $countSwitches = $order->countProductsByCategory( Product::CATEGORY_SWITCHES );
        $freeSwitches  = $this->freeSwitches( $countSwitches );

        if ( $freeSwitches > 0 ) {
            $items = $order->items;

            foreach ( $items as $item ) {
                $product = $item->product;
                if ( $product->category == Product::CATEGORY_SWITCHES ) {
                    $unitPrice = $product->price;
                }
            }

            $discount = new \App\Discount();
            $discount->order()->associate( $order );
            $discount->type        = $this->getType();
            $discount->description = $this->getDescription();
            $discount->amount      = $freeSwitches * $unitPrice;
            $discount->save();
        }
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