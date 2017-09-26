<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 20/09/2017
 * Time: 14:44
 */

namespace App\Discounts;

use App\Order;
use App\Product;

class ToolsDiscount implements Discount {

    /**
     * @return string
     */
    public function getType(): string {
        return self::TYPE_AMOUNT;
    }

    /**
     * Discount description
     *
     * @return string
     */
    public function getDescription(): string {
        return 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.';
    }

    /**
     * Calculate and creates the Discout
     *
     * @param Order $order
     *
     * @return \App\Discount|null|void
     */
    public function calculateDiscount( Order $order ) {
        $countTools = $order->countProductsByCategory( Product::CATEGORY_TOOLS );

        if ( $countTools > 1 ) {
            $discount = new \App\Discount();
            $discount->order()->associate( $order );
            $discount->type        = $this->getType();
            $discount->description = $this->getDescription();
            $discount->amount      = (float) $order->cheapestProduct( Product::CATEGORY_TOOLS )->price * 0.2;
            $discount->save();
        }
    }

}
