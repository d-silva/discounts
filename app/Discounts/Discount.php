<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 19/09/2017
 * Time: 19:47
 */

namespace  App\Discounts;

use \App\Order;

/**
 * Interface Discount
 * @package App\Discounts
 */

interface Discount {
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_AMOUNT = 'amount';

    //public function __construct(Order $order);

    /**
     * Returns the order in wich the discount run in comparison to other discounts
     *
     * Starting from 0
     *
     * @return int
     */
    public static function getRunOrder(): int;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return float
     */
    public function getDiscount(): array;


    public function calculateDiscount(Order $order);

}