<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 16-09-2017
 * Time: 23:16
 */

namespace App\Http\Controllers;

use App\Item;
use App\Order;
use App\Product;
use App\Customer;
use Illuminate\Http\Request;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Integer;

class OrderController extends Controller {

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

				$newItem->quantity = $item['quantity'];

				//Inserting item directly in the relation with the order
				$order->items()->save( $newItem );
			}

			$discounts = $this->calculateDiscount( $order );

			return response()->json( [$order, $discounts] );

		} catch ( Exception $exception ) {
			return response()->json( 'Failed with message: ' . $exception->getMessage() );
		}

	}

	private function calculateDiscount( Order $order ) {
		return [
			$this->discountRule1($order),
			$this->discountRule2($order),
			$this->discountRule3($order)
		];
	}

	private function discountRule1( $order ) {
		$discount = [
			'total' => 0,
			'description' => 'A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.'
		];

		$customer = $order->customer;

		if ( $customer->revenue >= 1000 ) {
			$discount['total'] = $order->total * 0.10;
		}

		return $discount;
	}

	private function discountRule3( $order ) {
		$unitPrice = 0;
		$totalSwitches = $this->countByCategory( $order, Product::CATEGORY_SWITCHES );

		$freeSwitches = $this->freeSwitches( $totalSwitches );

		$items = $order->items;

		foreach ( $items as $item ) {
			$product = $item->product;
			if ( $product->category == Product::CATEGORY_SWITCHES ) {
				$unitPrice = $product->price;
			}
		}

		return [
			'total' => $freeSwitches * $unitPrice,
			'switches' => $totalSwitches,
			'description' => 'For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.'
		];
	}

	/**
	 * Returns the quantity of free switches in the order
	 *
	 * @param $total
	 * @param int $freeSwitches
	 *
	 * @return int
	 */
	private function freeSwitches( $total, $freeSwitches = 0 ) {

		if ( ( $total - 6 ) >= 0 ) {
			$freeSwitches ++;

			return $this->freeSwitches( $total - 6, $freeSwitches );
		}

		return $freeSwitches;
	}


	private function discountRule2( Order $order ) {
		$discount = [
			'total' => 0,
			'tools' => 0,
			'description' => 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.'
		];

		$totalTools = $this->countByCategory( $order, Product::CATEGORY_TOOLS );
		if ( $totalTools > 1 ) {
			$discount['total'] = $this->getCheapestProduct( $order )->price;
		}

		$discount['tools'] = $totalTools;

		return $discount;

	}

	/**
	 * Counts the Products with a given category present in a Order
	 *
	 * @param Order $order
	 * @param $category
	 *
	 * @return int
	 */
	private function countByCategory( Order $order, $category ) {
		$items = $order->items();

		return (int) $items->join( 'products', 'items.product_id', '=', 'products.id' )
		             ->where( 'products.category', '=', $category )
		             ->sum('items.quantity');
	}

	/**
	 * Return cheapest Product in the Order
	 *
	 * @param Order $order
	 *
	 * @return mixed
	 */
	private function getCheapestProduct( Order $order ) {

		return $order->items()
		             ->join( 'products', 'items.product_id', '=', 'products.id' )
		             ->orderBy( 'products.price', 'asc' )
		             ->first();
	}
}