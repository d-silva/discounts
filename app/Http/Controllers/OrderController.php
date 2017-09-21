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
    private $discounts;

    /**
     * OrderController constructor.
     *
     * @param OrderTransformer $orderTransformer
     * @param Discount $discount
     */
    public function __construct( OrderTransformer $orderTransformer, DiscountCollection $discounts ) {
        $this->orderTransformer = $orderTransformer;
        $this->discounts        = $discounts;
    }

    public function index() {
        $orders = Order::all();

        return response()->json( $orders );
    }

    public function createOrder( Request $request ) {

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

            $discounts = $this->orderDiscount( $order );
            $order->setDiscounts( $discounts );

            return response()->json( $this->orderTransformer->transformOutput( $order ) );

        } catch ( Exception $exception ) {
            return response()->json( 'Failed with message: ' . $exception->getMessage(), 400 );
        }

    }

    private function orderDiscount( Order $order ) {
        $discountsApplied = [];

        foreach ( $this->discounts as $discount ) {
            if ( $discount->calculateDiscount( $order ) > 0 ) {
                $discountsApplied[] = $discount->getDiscount();
            }
        }

        return $discountsApplied;
    }
}

