<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    //
    public function index(Request $request)
    {

        // $filters = $request->all();

        $currentUserId = auth()->user()->id;
        $tasks = Task::where('user_id', $currentUserId)
            ->with('user')
            ->with('tag')
            ->with('category');

        // if (isset($filters['tag'])) {
        //     // Filter tasks by tag
        //     $tag = '%' . $filters['tag'] . '%';
        //     $tasks->whereHas('tag', function ($query) use ($tag) {
        //         $query->where('name', 'like', $tag);
        //     });

        // }
        // if (isset($filters['category'])) {
        //     // Filter tasks by tag
        //     $category = '%' . $filters['category'] . '%';
        //     $tasks->whereHas('category', function ($query) use ($category) {
        //         $query->where('name', 'like', $category);
        //     });

        // }
        $tasks = $tasks->get();
        return response()->json([
            "data" => $tasks
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

    }
    public function show($id)
    {
        $currentUserId = auth()->user()->id;

        $task = Task::where('user_id', $currentUserId)->with('user')
            ->with('tag')
            ->with('category')->find($id);
        if (!empty($task)) {
            return response()->json($task, 200);
        } else {
            return response()->json([
                "message" => "Task don't exist"
            ], 404);

        }

    }
}