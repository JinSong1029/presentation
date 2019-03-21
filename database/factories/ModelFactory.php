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

use Carbon\Carbon;

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'password_open' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Presentation\DefaultSections::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Models\Presentation::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'client' => $faker->word,
        'key' => $faker->randomAscii,
        'hidden' => 0,
        'archived' => 0,
        'author_id' => null,
        'presenter_id' => null,
        'presentation_date' => Carbon::now()->toDateTimeString(),
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString()
    ];
});

$factory->define(App\Models\Section::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'ordering' => $faker->randomDigit
    ];
});

$factory->define(App\Models\Slide::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'type' => $faker->randomElement($array = ['picture', 'tombstone', 'logo','text','video']),
        'ordering' => $faker->randomDigit,
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString()
    ];
});
$factory->define(App\Models\SlideTypes\Tombstone::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'image' => $faker->image(),
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString()
    ];
});
$factory->define(App\Models\SlideTypes\Text::class, function (Faker\Generator $faker) {
    return [
        'text' => $faker->realText(255),
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString()
    ];
});