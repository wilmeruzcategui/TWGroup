<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Log;
use App\Mail\LogMail;
use Mail;

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

    public function edit(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required',
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

         $task = Task::find($request->id);
         $task->description = $request->taskdescription;
         $task->user_id = $request->taskuser;
         $task->date = $date->format('Y-m-d');
         $task->save();

         return redirect()->route('home')->with('success', 'Task edit successfully');

    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $res=Task::where('id',$request->id)->delete();

    }

    public function logs(Request $request)
    {
        $logs = Log::where('task_id', $request->id)->get();
        return view('logs')->with(compact('logs'));
    }

    public function addlog(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'addlog' => 'required',
        ]);

        $task = new Log;
        $task->comment = $request->addlog;
        $task->task_id = $request->id;
        $task->save();

        Mail::to('wilmeruzcategui5@hotmail.com')->send(new LogMail());

        $logs = Log::where('task_id', $request->id)->get();

        return view('logs')->with(compact('logs'));

    }
}
