<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index()
    {
        try{

            $tasks = Task::all();

            return response()->json($tasks, Response::HTTP_OK);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:pending,in-progress,completed',
                'assigned_user' => 'nullable|exists:users,id',
            ]);
    
            $task = Task::create([
                'name' => $request->name,
                'status' => $request->status,
                'user_id' => auth()->id(),
                'assigned_user' => $request->assigned_user,
            ]);
    
            return response()->json($task, Response::HTTP_CREATED);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function destroy($id)
    {
        try{
            $task = Task::where('id',$id)->firstOrFail();

            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function assign(Request $request, $id)
    {
        try{
            $user = $request->id;

            $task= Task::where('id',$id)->firstOrFail();

            $task->assigned_user = $user;
            $task->save();

            return response()->json($task, Response::HTTP_OK);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }
  

    public function update(Request $request, Task $task)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:pending,completed',
                'assigned_user' => 'nullable|exists:users,id',
            ]);
    
            $task->update([
                'name' => $request->name,
                'status' => $request->status,
                'assigned_user' => $request->assigned_user,
            ]);
    
            return response()->json($task, Response::HTTP_OK);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
   
}
