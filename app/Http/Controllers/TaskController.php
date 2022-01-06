<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {

        $validated = $request->validate([
            'taskdescription' => 'required',
            'taskuser' => 'required',
            'taskdate' => 'required',
        ],
        [
            'taskdescription.required'=> 'Task Description is Required',
            'taskuser.required'=> 'Responsible user is required',
            'taskdate.required'=> 'Field task date is required'
         ]);


         $date = \DateTime::createFromFormat('d/m/Y', $request->taskdate);

         $task = new Task;
         $task->description = $request->taskdescription;
         $task->user_id = $request->taskuser;
         $task->date = $date->format('Y-m-d');
         $task->save();

         return redirect()->route('home')->with('success', 'Task create successfully');

    }
}
