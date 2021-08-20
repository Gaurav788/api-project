<?php
 
use App\{Review, Product, User}; 
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'review' => $faker->paragraph,
        'rating' => $faker->numberBetween(0, 5),
        'status' => 0,
        'user_id' => function() {
            return User::all()->random();
        },
        'product_id' => function() {
            return Product::all()->random();
        }];
});
