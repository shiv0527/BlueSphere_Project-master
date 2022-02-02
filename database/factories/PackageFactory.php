<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'package_name' => $this->faker->randomElement($array = array ('Gold','Silver','Platinum', 'Diamond')),
            'package_benefits' => $this->faker->numerify('##'),
            'package_duration' => $this->faker->randomElement($array = array ('Daily','Weekly','Monthly', 'Yearly')),
            'price'  => $this->faker->numerify('##'),
            'is_active' => $this->faker->randomElement($array = array('Yes', 'No')),
            'is_recurring' => $this->faker->randomElement($array = array('Yes', 'No')),
        ];
    }
}

// $table->increments('id');  
//             $table->string('first_name', 25);
//             $table->string('last_name', 25);
//             $table->string('email', 50)->unique();
//             $table->string('package_id')->index();
//             $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
//             $table->timestamp('email_verified_at')->nullable();
//             $table->string('password')->nullable();
//             $table->boolean('owner')->default(false);
//             $table->string('photo_path', 100)->nullable();
//             $table->rememberToken();
//             $table->timestamps();
//             $table->softDeletes();
