<?php

use Faker\Generator as Faker;

$factory->define(\App\Modules\Argaam\Models\Article::class, function (Faker $faker) {
    return [
        
            'title' =>  $faker->name ,
            'content' =>  $faker->text ,
            'category_id'  =>  $faker->numberBetween(0, 50) ,
            'user_id'  =>  $faker->numberBetween(0, 50), 
            'published'  =>  $faker->numberBetween(0, 1),
    ];
});
