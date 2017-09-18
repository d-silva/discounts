<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 20:38
 */

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller {

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$customers = Customer::all();

		return response()->json($customers);
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createCustomer(Request $request) {
		$customer = Customer::create($request->all());

		return response()->json($customer);
	}

	public function deleteCustomer($customerId) {
		$customer = Customer::find($customerId);
		$customer->delete();

		return response()->json('Removed customer ' . $customerId . ' successfully.');
	}

	public function updateCustomer(Request $request, $customerId) {
		$customer = Customer::find($customerId);
		$customer->revenue($request->input('revenue'));
		$customer->save();

		return response()->json($customer);
	}
}