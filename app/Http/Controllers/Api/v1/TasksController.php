<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    //
    public function tasks(Request $request){

      
        $currentUserId = auth()->user()->id;
        $tasks = Tasks::where('user_id', $currentUserId)
        ->with('user')
        ->with('tag')
        ->with('category')
        ->get();
        
        return response()->json([
            "data" =>$tasks
        ],200);
    }
}
