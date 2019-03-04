<?php

use Faker\Generator as Faker;

$factory->define(\App\Modules\Argaam\Models\Category::class, function (Faker $faker) {
    return [
        
            'name' =>  $faker->name ,
    ];
});
