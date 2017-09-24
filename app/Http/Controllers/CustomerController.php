<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 20:38
 */

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Transformers\CustomerTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CustomerController extends Controller {

    /**
     * @var CustomerTransformer
     */
    private $transformer;

    /**
     * OrderController constructor.
     *
     * @param CustomerTransformer $transformer
     *
     * @internal param OrderTransformer $orderTransformer
     * @internal param Discount $discount
     */
    public function __construct( CustomerTransformer $transformer ) {
        $this->transformer = $transformer;
    }

    /**
     * List Customer(s)
     *
     * @param int|null $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( int $id = null ) {
        try {
            if ( ! is_null( $id ) ) {
                return response()->json( Customer::findOrFail( $id ) );
            }

            return response()->json( Customer::all() );
        } catch ( ModelNotFoundException $e ) {
            return response()->json( 'Customer does not exist', 404 );
        }
    }

    /**
     * Create Customer
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( Request $request ) {
        $customer = Customer::create( $this->transformer->transformInput( $request ) );
        $customer->save();

        return response()->json( $customer );
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
            $customer = Customer::findOrFail( $id );
            $customer->delete();

            return response()->json( 'Removed customer ' . $id . ' successfully.' );
        } catch ( ModelNotFoundException $exception ) {
            return response()->json( 'Customer does not exist', 204 );
        }
    }

    /**
     * Update Customer
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( Request $request, $id ) {
        try {
            $customer = Customer::findOrFail( $id );
            $customer->fill( $request->all() );
            $customer->save();

            return response()->json( $customer );
        } catch ( ModelNotFoundException $exception ) {
            return response()->json( 'Customer does not exist', 404 );
        }
    }
}