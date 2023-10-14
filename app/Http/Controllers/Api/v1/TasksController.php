<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
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
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->toArray();
        $data['due_date'] = Carbon::createFromDate($data['due_date']);

        try {
            //code...
            // echo "<pre>";
            // print_r($request->toArray());
            // die;
            if (isset($data['task_id'])) {

                $task = Task::find($data['task_id']);
                if ($task) {
                $task->name = $data['name'];
                $task->due_date = $data['due_date'];
                $task->category_id = $data['category_id'];
                $task->user_id = $data['user_id'];
                $task->save();
                return response()->json(['message' => "task is Updated "]);
            }
            return response()->json(['error' => "Task don't exit maybe it is deleted "]);
            }

            $task = Task::create($data);
            if ($task) {
                return response()->json(['message' => "task is added"]);
            }
            return response()->json(['error' => "Can't add task"]);

        } catch (\Throwable $th) {
            throw $th;
            // return response()->json(['error' => "Can't add task Please check due_date make sure it is in correct datetime format "]);

        }

        // print_r();
        // die;


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
    public function delete($id)
    {
        $currentUserId = auth()->user()->id;

        $task = Task::where('user_id', $currentUserId)->with('user')
            ->with('tag')
            ->with('category')->find($id);


        if (!empty($task)) {
            $task->delete();
            return response()->json([
                "message" => "Successfully Deleted Task"
            ], 200);
        } else {
            return response()->json([
                "message" => "Task don't exist"
            ], 404);

        }

    }
}