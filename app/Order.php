<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 17-09-2017
 * Time: 23:16
 */


namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	public $timestamps = false;

	protected $primaryKey = 'id';

	protected $fillable = [ 'id', 'customer_id', 'total' ];

	/**
	 * Get the order that owns the comment.
	 */
	public function customer() {
		return $this->belongsTo( 'App\Customer' );
	}

	/**
	 * The items that belong to the order.
	 */
	public function items() {
		return $this->hasMany( 'App\Item' );
	}

}