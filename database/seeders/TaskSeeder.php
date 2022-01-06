<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $task = new Task;
            $task->description = "Tarea " . Str::random(10);
            $task->date = date('Y-m-d');
            $task->save();
        }
    }
}
