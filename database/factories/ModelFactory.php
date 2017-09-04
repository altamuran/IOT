<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Sensori::class, function (Faker\Generator $faker) {

    return [
    	 //'id'=>$faker->randomDigitNotNull,
        'identificatore' => $faker->word,
        'codice' => $faker->randomNumber,
        'info' =>$faker->word,
        'user'=>App\User::all()->shuffle()->slice(0,1)->first()->id,
        'ambiente'=>App\ambienti::all()->shuffle()->slice(0,1)->first()->id,
        //'created_at'=>$faker->dateTime,
        //'updated_at'=>$faker->dateTime,

        
            ];
});


$factory->define(App\ambienti::class, function (Faker\Generator $faker) {

    return [
         
        'descrizione' => $faker->word,
        'n_sensori' => $faker->randomNumber,
        ];
});