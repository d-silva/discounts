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

	const SWITCH_CATEGORY = 2;

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	protected $primaryKey = 'id';

	protected $fillable = ['id', 'description', 'category', 'price'];

	public function isSwitch() {
		return $this->category == self::SWITCH_CATEGORY;
	}
}