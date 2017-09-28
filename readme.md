# Problem : Discounts

Small (micro)service that calculates discounts for orders.

## How discounts work

For now, there are three possible ways of getting a discount:

- A customer who has already bought for over € 1000, gets a discount of 10% on the whole order.
- For every products of category "Switches" (id 2), when you buy five, you get a sixth for free.
- If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.


##### Note
If you want to add more discounts you'll have to create a new class that implements ```App\Discounts``` interface and
instantiate it in ```AppServiceProvider.php``` file  at ```App\Providers\AppServiceProvider``` namespace in the ```DiscountCollection``` instantiation.
The order in wich the discounts are instantiated is the order in which they will be applied 

## Run ##
1. vagrant up
2. Copy the **Client ID: 2** output of ```php artisan passport:install``` command and fill the last two params of .env 
with that info.
3. Fill the rest of the .env file with the 
3. Access API on 192.168.33.10

### Routes ###

| METHOD | URI |
|--------|------------------------------|
| POST | /login |
|  |  |
| GET | /discounts/v1/customers |
| GET | /discounts/v1/customers/{id} |
| POST | /discounts/v1/customers |
| PUT | /discounts/v1/customers/{id} |
| DELETE | /discounts/v1/customers/{id} |
|  |  |
| GET | /discounts/v1/products/ |
| GET | /discounts/v1/products/{id} |
| POST | /discounts/v1/products/ |
| PUT | /discounts/v1/products/{id} |
| DELETE | /discounts/v1/products/{id} |
|  |  |
| GET | /discounts/v1/orders |
| GET | /discounts/v1/orders/{id} |
| POST | /discounts/v1/orders |


## License

Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
