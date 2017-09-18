<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 20:36
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	protected $primaryKey = 'id';

	protected $fillable = ['id', 'name', 'since', 'revenue'];

	/**
	 * Get the customer orders.
	 */
	public function orders()
	{
		return $this->hasMany('App\Order');
	}
}