<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $taskData = [
            'name' => 'Test Task',
            'status' => 'pending',
        ];

        $response = $this->postJson(route('tasks.store'), $taskData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'name' => 'Test Task',
                'status' => 'pending',
                'user_id' => $user->id,
            ]);

        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    public function test_it_can_update_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'name' => 'Updated Task Name',
            'status' => 'completed',
        ];

        $response = $this->putJson(route('tasks.update', ['task' => $task->id]), $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'name' => 'Updated Task Name',
                'status' => 'completed',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
            'status' => 'completed',
        ]);
    }

    public function test_it_can_assign_a_task_to_a_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $assignedUser = User::factory()->create();

        $response = $this->putJson(route('tasks.assign', ['task' => $task->id, 'user' => $assignedUser->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['assigned_user' => $assignedUser->id]);

        $this->assertEquals($assignedUser->id, $task->fresh()->assigned_user);
    }

    public function test_it_can_delete_a_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('tasks.destroy', ['task' => $task->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
