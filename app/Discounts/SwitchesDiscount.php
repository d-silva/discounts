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
    public function calculateDiscount( Order $order ) {
        $amount        = 0;
        $countSwitches = $order->countProductsByCategory( Product::CATEGORY_SWITCHES );
        $freeSwitches  = $this->freeSwitches( $countSwitches );


        if ( $freeSwitches > 0 ) {
            $switches = $order->getItemsByCategoryProduct( Product::CATEGORY_SWITCHES );
//            $nCheapestProducts = $order->cheapestProduct( Product::CATEGORY_SWITCHES, $freeSwitches);

            foreach ( $switches as $item ) {

                if ( $freeSwitches <= 0 ) {
                    break;
                }

                if ( $freeSwitches <= $item->quantity ) {
                    $amount += ( $item->unit_price * $freeSwitches );
                    break;
                } else {
                    $amount       += ( $item->unit_price * $item->quantity );
                    $freeSwitches -= $item->quantity;
                }

            }

            $discount = new \App\Discount();
            $discount->order()->associate( $order );
            $discount->type        = $this->getType();
            $discount->description = $this->getDescription();
            $discount->amount      = $amount;
            $discount->save();
        }
    }

    /**
     * Returns the quantity of free switches in the order
     *
     * @param     $total
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