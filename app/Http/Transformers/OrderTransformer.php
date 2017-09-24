<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 19-09-2017
 * Time: 1:28
 */

namespace App\Http\Transformers;

use App\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderTransformer extends Transformer {

    public function transformInput( $request ) {
        return [
            'id'          => $request->input( 'id' ),
            'customer_id' => $request->input( 'customer-id' ),
            'items'       => $request->input( 'items' ),
            'total'       => $request->input( 'total' ),
        ];
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function transformOutput( $item ) {

        if ( $item instanceof Collection ) {
            $result = [];

            foreach ( $item as $order ) {

                $result[] = $this->getOutputFormat( $order );
            }
        } else {
            $result = $this->getOutputFormat( $item );
        }

        return $result;
    }

    private function getOutputFormat( Order $order ) {
        return [
            'id'                    => $order->id,
            'customer-id'           => $order->customer->id,
            'items'                 => $order->itemsOutput(),
            'total'                 => $order->total,
            'discounts'             => $order->discountsOutput(),
            'total-after-discounts' => $order->total - $order->getTotalDiscounts(),
        ];
    }
}