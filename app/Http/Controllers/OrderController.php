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

class OrderController extends Controller {

	public function index() {
		$orders = Order::all();

		return response()->json($orders);
	}

	public function createOrder(Request $request) {

		try {
			$order = new Order();
			$order->id = $request->input('id');

			// Get customer and associate it to the order
			$customer = Customer::find($request->input('customer-id'));
			$order->customer()->associate( $customer );

			$order->total = $request->input('total');
			$order->saveOrFail();

			$items = $request->input('items');
			foreach ($items as $item) {
				$newItem = new Item();

				//Associate the item to the order
				$newItem->order()->associate( $order );

				//Find the product and associate it to the item
				$product = Product::find($item['product-id']);
				$newItem->product()->associate($product);

				$newItem->quantity = $item['quantity'];

				//Inserting item directly in the relation with the order
				$order->items()->saveOrFail($newItem);
			}

			return response()->json($order);

		} catch (Exception $exception) {
			return response()->json('Failed with message: ' . $exception->getMessage());
		}

	}
}