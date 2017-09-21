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

    protected $discounts = [];

    /**
     * Get the order that owns the comment.
     */
    public function customer() {
        return $this->belongsTo( 'App\Customer' );
    }

    /**
     * The items that belong to the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany( 'App\Item' );
    }

    public function itemsOutput() {
        return $this->hasMany( 'App\Item' )->get( [ 'product_id', 'quantity', 'unit_price' ] );
    }

    /**
     * Return the Order cheapest Product
     *
     * @return Model|null|static
     */
    public function cheapestProduct() {
        return $this->items()
                    ->join( 'products', 'items.product_id', '=', 'products.id' )
                    ->orderBy( 'products.price', 'asc' )
                    ->first();
    }

    /**
     * Counts the Products with a given category present in a Order
     *
     * @param $category
     *
     * @return int
     */
    public function countProductsByCategory( $category ) {
        $items = $this->items();

        return (int) $this->items()
                          ->join( 'products', 'items.product_id', '=', 'products.id' )
                          ->where( 'products.category', '=', $category )
                          ->sum( 'items.quantity' );
    }


    public function setDiscounts( $discounts ) {
        $this->discounts = $discounts;
    }

    public function getDiscounts() {
        return $this->discounts;
    }

    public function getTotalDiscounts() {
        $total = 0;

        array_walk_recursive( $this->discounts,
            function ( $val, $key ) use ( &$total ) {
                if ( $key == 'total' ) {
                    $total = $total + $val;
                }
            } );

        return $total;
    }

}