<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 19-09-2017
 * Time: 1:28
 */

namespace App\Http\Transformers;

use App\Order;
use Illuminate\Http\Request;

class OrderTransformer extends Transformer {

    public function transformInput( $order ) {

    }

    public function transformOutput( $order ) {
        return [
            'id'                    => $order->id,
            'customer-id'           => $order->customer->id,
            'items'                 => $order->itemsOutput(),
            'total'                 => $order->total,
            'discounts_applied'     => $order->getDiscounts(),
            'total_after_discounts' => $order->total - $order->getTotalDiscounts(),
        ];
    }
}