<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskTodo;


class TaskTodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = TaskTodo::where('user_id', auth()->user()->id)->get();
 
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function show($id){
        $task = auth()->user()->taskTodo->find($id);
 
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $task->toArray()
        ], 400);
    }

    public function store(Request $request){
        
         $this->validate($request, [
            'title' => 'required'
        ]);

        $task = new TaskTodo();
        $task->title= $request->title;

        if(auth()->user()->taskTodo()->save($task)){
            return response()->json([
                'success' => true,
                'data' => $task->toArray()
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Task could not be added'
            ], 500);
        }
      
    }

    public function destroy( $id){
        $task = auth()->user()->taskTodo()->find($id);
        
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task with id ' . $id . ' not found'
            ], 400);
        }else{
            if( $task->delete()){
                return response()->json([
                    'success' => true
                ]);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Product could not be deleted'
                ], 500);
            }
        }   
    }

    public function update(Request $request, TaskTodo $task){
        if ($task->user_id !== auth()->user()->id) {
            return response()->json('Unauthorized', 401);
        }
        $data = $request->validate([
            'title' => 'required|string',
            'completed' => 'required|boolean',
        ]);
        $task->update($data);
        return response($task, 200);
    }


}
