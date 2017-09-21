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
     * @var float
     */
    private $discount = 0.0;

    /**
     * @var int
     */
    private $toolsInTheOrder;

    /**
     * Returns the order in wich the discount run in comparison to other discounts
     *
     * Starting from 0
     *
     * @return int
     */
    public static function getRunOrder(): int {
        return 0;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return self::TYPE_AMOUNT;
    }

    /**
     * @return float
     */
    public function getDiscount(): array {
        return $discount = [
            'total' => $this->discount,
            'tools' => $this->toolsInTheOrder,
            'description' => 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.'
        ];
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function calculateDiscount(Order $order) {

        $this->toolsInTheOrder = $order->countProductsByCategory(Product::CATEGORY_TOOLS );

        if ( $this->toolsInTheOrder > 1 ) {
            $this->discount = $order->cheapestProduct()->price * 0.2;
        }
    }
}
