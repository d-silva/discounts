<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 19/09/2017
 * Time: 19:47
 */

namespace App\Discounts;

use \App\Order;

/**
 * Interface Discount
 * @package App\Discounts
 */
interface Discount {
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_AMOUNT = 'amount';

    /**
     * Discount type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Discount description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Calculate and creates the discount
     *
     * @param Order $order
     *
     * @return \App\Discount|null
     */
    public function calculateDiscount( Order $order );

}