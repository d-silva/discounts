<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 19/09/2017
 * Time: 20:00
 */

namespace App\Discounts;

use App\Order;
use App\Product;

class VipDiscount implements Discount {

    /**
     * Discount type
     *
     * @return string
     */
    public function getType(): string {
        return self::TYPE_PERCENTAGE;
    }

    /**
     * Discount description
     *
     * @return string
     */
    public function getDescription(): string {
        return 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.';
    }

    /**
     * Creates the discount
     *
     * @param Order $order
     */
    public function calculateDiscount( Order $order ) {
        $customer = $order->customer;

        if ( $customer->revenue >= 1000 ) {
            $discount = new \App\Discount();
            $discount->order()->associate( $order );
            $discount->description = $this->getDescription();
            $discount->type        = $this->getType();
            $discount->amount      = (float) $order->total * 0.10;
            $discount->save();
        }
    }
}