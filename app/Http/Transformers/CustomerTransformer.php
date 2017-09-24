<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 23/09/2017
 * Time: 23:12
 */

namespace App\Http\Transformers;

use App\Order;
use Illuminate\Database\Eloquent\Collection;

class CustomerTransformer extends Transformer {

    public function transformInput( $request ) {
        return [
            'name'    => $request->input( 'name' ),
            'since'   => $request->input( 'since' )
                ? $request->input( 'since' )
                : date( 'Y-m-d' ),
            'revenue' => $request->input( 'revenue' )
                ? $request->input( 'revenue' )
                : 0,
        ];
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function transformOutput( $item ) {

    }
}