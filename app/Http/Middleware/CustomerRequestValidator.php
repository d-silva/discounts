<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class CustomerRequestValidator {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next ) {

        if ( ! $request->isMethod( 'POST' ) ) {
            return $next( $request );
        }

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make( $request->input(), $rules );

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );

        }

        return $next( $request );
    }
}
