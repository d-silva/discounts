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
     * @var float
     */
    private $discount = 0.0;

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
            'total'       => $this->discount,
            'description' => 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.',
        ];
    }

    /**
     * @param Order $order
     *
     */
    public function calculateDiscount(Order $order) {

        $customer = $order->customer;

        if ( $customer->revenue >= 1000 ) {
            $this->discount = $order->total * 0.10;
        }
    }

    /**
     * Returns the order in wich the discount run in comparison to other discounts
     *
     * @return int
     */
    public static function getRunOrder(): int {
        return 2;
    }

}