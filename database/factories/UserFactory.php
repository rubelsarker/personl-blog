<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return array(

        'role_id' =>2,
        'name' => $faker->firstName,
        'username' => $faker->unique()->lastName,
        'email' => $faker->unique()->safeEmail,
        'password'=>bcrypt('12345678'),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'about' => $faker->paragraphs($nb = 3, $asText = false),
        'created_at' => now(),
        'updated_at' => now(),
    );
});
