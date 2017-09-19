<?php
/**
 * Created by PhpStorm.
 * User: dsilva
 * Date: 19-09-2017
 * Time: 7:15
 */

namespace App\Http\Transformers;

abstract class Transformer {

	public function transformCollection(array $items) {

		return array_map([$this, 'transform'], $items);

	}

	public abstract function transformInput($item);

	public abstract function transformOutput($item);

}