<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 22/09/2017
 * Time: 22:26
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class ProductRequestValidator {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next ) {

        if ( $request->isMethod( 'DELETE' ) || $request->isMethod( 'GET' ) ) {
            return $next( $request );
        }

        $rules = [
            'id'          => 'required|unique:products,id',
            'description' => 'string|max:255',
            'category'    => 'required|numeric',
            'price'       => 'required|numeric',
        ];

        $validator = Validator::make( $request->input(), $rules );

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );

        }

        return $next( $request );

    }
}
