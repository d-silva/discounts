<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 23:09
 */

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

	/**
	 * Lists all products
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$products = Product::all();

		return response()->json($products);
	}

	public function createProduct(Request $request) {
		$product = Product::create($request->all());

		return response()->json($product);
	}

	public function updateProduct(Request $request, $productId) {
		$product = Product::find($productId);

		$product->id = $request->input('id');

		$product->save();

		return response()->json($product);
	}

	public function deleteProduct($productId) {
		$product = Product::find($productId);

		$product->delete();

		return response()->json('Product ' . $productId . ' deleted successfully');
	}
}