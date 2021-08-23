<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        # 디비 구조
//        - 할일
//        - 제목 : string required
//        - 내용 : longtext optional
//        - 마감기한 : date optional
//        - 완료여부 : boolean default false
        return [
            'title' => $this->faker->text(15),
            'content' => $this->faker->text(100)
        ];
    }
}
