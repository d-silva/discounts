<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 23/09/2017
 * Time: 23:06
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model {

    /**
     * Set to false to prevent Laravel Eloquent to automatically create created_at and updated_at columns
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [ 'order_id', 'type', 'description', 'amount' ];

    /**
     * Get the order that owns the comment.
     */
    public function order() {
        return $this->belongsTo( 'App\Order' );
    }
}
