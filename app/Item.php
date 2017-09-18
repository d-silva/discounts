<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 17-09-2017
 * Time: 23:26
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * To be able to set the id when creating a new item
	 * @var bool
	 */
	public $incrementing = false;

	protected $fillable = ['order_id', 'product_id', 'quantity'];

	/**
	 * Get the order that owns the comment.
	 */
	public function order()
	{
		return $this->belongsTo('App\Order');
	}

	/**
	 * Get the product that the item belong to.
	 */
	public function product()
	{
		return $this->belongsTo('App\Product');
	}
}
