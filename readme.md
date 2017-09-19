# Problem : Discounts

Small (micro)service that calculates discounts for orders.

## How discounts work

For now, there are three possible ways of getting a discount:

- A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
- For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.
- If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.

## License

Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)


## Run ##
1. php artisan create-schema
2. php artisan migrate
3. php artisan db:seed