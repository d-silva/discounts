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

class CustomerController extends ApiController {

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

            return $this->respond( [ 'data' => Customer::all() ] );
        } catch ( ModelNotFoundException $e ) {
            return $this->respondNotFound( 'Customer does not exist' );
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

        return $this->respond( [ 'data' => $customer ] );
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

            return $this->respond( 'Removed customer ' . $id . ' successfully.' );
        } catch ( ModelNotFoundException $exception ) {
            return $this->setStatusCode( 204 )->respond( 'Customer does not exist' );
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

            return $this->respond( [ 'data' => $customer ] );
        } catch ( ModelNotFoundException $exception ) {
            return $this->respondNotFound( 'Customer does not exist' );
        }
    }
}