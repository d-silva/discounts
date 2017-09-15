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

	/**
	 * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
	 * @var bool
	 */
	public $timestamps = false;

	protected $fillable = ['id', 'description', 'category', 'price'];
}