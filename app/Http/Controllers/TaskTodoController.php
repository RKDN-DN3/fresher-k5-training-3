<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskTodo;

class TaskTodoController extends Controller
{
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
        $data = $request->all();
        return TaskTodo::create([
            'user_id'=>$data['user_id'],
            'title'=>$data['title']
        ]);
       /* if( TaskTodo::save($task)){
            
            return response()->json(
                [
                    'success' => true,
                    'data' => $task->toArray()
                ]
                );
        }
        else{
            return response()->json(
                [
                    'success' => false,
                    'data' => 'Task not Add'
                ]
                );
        } */
    }

    public function destroy(TaskTodo $task){
        if ($task->user_id !== auth()->user()->id) {
            return response()->json('Unauthorized', 401);
        }
        $task->delete();
        return response()->json('deleted task item');


        /* $task =  auth()->user()->taskTodo->find($id);
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 400);
        }
        if ($task->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Task can not be deleted'
            ], 500);
        } */
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
