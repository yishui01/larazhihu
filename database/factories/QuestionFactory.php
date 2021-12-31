<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => function () {
                return User::factory()->create()->id;
            },
            'title'       => $this->faker->sentence,
            'content'     => $this->faker->text,
            'category_id' => function () {
                return Category::factory()->create()->id;
            }
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => Carbon::parse('-1 week')
            ];
        });
    }

    public function unpublished()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null
            ];
        });
    }
}
