<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tasks = \App\Models\Task::all();

        foreach ($tasks as $task) {
            \App\Models\Comment::create([
                'task_id' => $task->id,
                'user_id' => 1,
                'body' => 'Progress sudah mencapai 50%, tinggal bagian responsif.',
            ]);
        }
    }
}