<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 21/09/2017
 * Time: 22:10
 */

namespace App\Discounts;

class DiscountCollection extends \Illuminate\Support\Collection {

    public function __construct( $items = [] ) {
        parent::__construct( $items );
    }

}