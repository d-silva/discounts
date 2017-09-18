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

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * To be able to set the id when creating a new order
	 * @var bool
	 */
	public $incrementing = false;

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