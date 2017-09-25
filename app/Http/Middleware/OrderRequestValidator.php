<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 22/09/2017
 * Time: 22:46
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderRequestValidator {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next ) {

        if ( $request->isMethod( 'GET' ) ) {
            return $next( $request );
        }

        $rules = [
            'id'                 => 'unique:orders,id|numeric',
            'customer-id'        => 'required|exists:customers,id',
            'items.*.product-id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|numeric',
            'items.*.unit-price' => 'required|numeric',
            'items.*.total'      => 'required|numeric',
            'total'              => 'required|numeric',

        ];

        $validator = Validator::make( $request->input(), $rules );

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );

        }

        return $next( $request );

    }
}
