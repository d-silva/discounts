<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 16-09-2017
 * Time: 23:16
 */

namespace App\Http\Controllers;

use App\Discounts\Discount;
use App\Discounts\DiscountCollection;
use App\Http\Transformers\OrderTransformer;
use App\Item;
use App\Order;
use App\Product;
use App\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;

class OrderController extends Controller {

    /**
     * @var OrderTransformer
     */
    protected $orderTransformer;

    /**
     * @var DiscountCollection
     */
    private $activeDiscounts;

    /**
     * OrderController constructor.
     *
     * @param OrderTransformer $orderTransformer
     * @param Discount $discount
     */
    public function __construct(
        OrderTransformer $orderTransformer,
        DiscountCollection $activeDiscounts
    ) {
        $this->orderTransformer = $orderTransformer;
        $this->activeDiscounts  = $activeDiscounts;
    }

    /**
     * Lists one Order by a given id or all Orders
     *
     * @param int|null $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( int $id = null ) {

        try {
            if ( ! is_null( $id ) ) {
                return response()->json( $this->orderTransformer->transformOutput( Order::findOrFail( $id ) ) );
            }

            return response()->json( $this->orderTransformer->transformOutput( Order::all() ) );
        } catch ( ModelNotFoundException $e ) {
            return response()->json( [], 404 );
        }
    }

    /**
     * Creates a Order and respective discounts associated with it
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store( Request $request ) {

        try {
            $order     = new Order();
            $order->id = $request->input( 'id' );

            // Get customer and associate it to the order
            $customer = Customer::find( $request->input( 'customer-id' ) );
            $order->customer()->associate( $customer );

            $total = $request->input( 'total' );

            //@TODO refact this to happen on associate belongsTo relationship
            $customer->revenue += $total;

            $order->total = $total;
            $order->saveOrFail();

            $items = $request->input( 'items' );
            foreach ( $items as $item ) {
                $newItem = new Item();

                //Associate the item to the order
                $newItem->order()->associate( $order );

                //Find the product and associate it to the item
                $product = Product::find( $item['product-id'] );
                $newItem->product()->associate( $product );

                $newItem->quantity   = $item['quantity'];
                $newItem->unit_price = $item['unit-price'];

                //Inserting item directly in the relation with the order
                $order->items()->save( $newItem );
            }

            // applying active discounts
            $this->applyDiscounts( $order );

            return response()->json( $this->orderTransformer->transformOutput( $order ) );

        } catch ( Exception $exception ) {
            return response()->json( 'Failed with message: ' . $exception->getMessage(), 400 );
        }

    }

    private function applyDiscounts( Order $order ) {
        foreach ( $this->activeDiscounts as $discount ) {
            $discount->calculateDiscount( $order );
        }
    }
}

