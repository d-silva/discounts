<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 23:09
 */

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends ApiController {

    /**
     * List one Product if product id is passed in url
     * or lists all existing Products
     *
     * @param int|null $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( string $id = null ) {
        try {
            if ( ! is_null( $id ) ) {
                return response()->json( Product::findOrFail( $id ) );
            }

            return $this->respond( [ 'data' => Product::all() ] );
        } catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound( 'Product does not exist' );
        }
    }

    /**
     * Create Product
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( Request $request ) {
        $product = Product::create( $request->all() );
        $product->save();

        return $this->respond( [ 'data' => $product ] );
    }

    /**
     * Delete Product
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete( $id ) {
        try {
            $product = Product::findOrFail( $id );
            $product->delete();

            return $this->respond( 'Removed product ' . $id . ' successfully.' );
        } catch ( ModelNotFoundException $exception ) {
            return $this->setStatusCode( 204 )->respond( 'Product does not exist' );
        }
    }

    /**
     * Update Product
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( Request $request, $id ) {
        try {
            $product = Product::findOrFail( $id );
            $product->fill( $request->all() );
            $product->save();

            return $this->respond( [ 'data' => $product ] );
        } catch ( ModelNotFoundException $exception ) {
            return $this->respondNotFound( 'Product does not exist' );
        }

    }
}