<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 15-09-2017
 * Time: 21:27
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	const CATEGORY_TOOLS = 1;
	const CATEGORY_SWITCHES = 2;

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * To be able to set the id when creating a new product
	 * @var bool
	 */
	public $incrementing = false;

	protected $primaryKey = 'id';

	protected $fillable = ['id', 'description', 'category', 'price'];

	public function isSwitch() {
		return $this->category == self::SWITCH_CATEGORY;
	}
}