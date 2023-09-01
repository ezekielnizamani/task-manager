<?php

namespace Database\Seeders;

// use Illuminate\Console\View\Components\Task;
use App\Models\Tasks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = \Faker\Factory::create();
        for($i =0; $i< 10; $i++){
            Tasks::create([
                "name" => $faker->name(),
                "description" => $faker->sentence(),
                "due_date" => $faker->date(),
                "status" =>"Pending",
                "user_id" =>1,
                "tag_id" =>1,
                "category_id" => 1
            ]);
        }
    }
}
