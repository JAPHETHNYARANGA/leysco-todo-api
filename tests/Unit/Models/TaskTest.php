<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function task_belongs_to_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->user);
    }

     /** @test */
     public function task_model_fillable_attributes()
    {
        $fillable = ['name', 'status', 'user_id'];

        $task = new Task();
        $this->assertEquals($fillable, $task->getFillable());
    }
}
