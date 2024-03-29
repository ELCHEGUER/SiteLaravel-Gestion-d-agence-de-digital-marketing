<?php

namespace App\Http\Controllers;
use App\Models\Charge;
use App\Models\Income;
use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function indexR(){
        $user = auth()->user();
        $tasks_done = Task::where('responsable_id', $user->id)->where('task_status', 1)->get();
        $tasks_not_done = Task::where('responsable_id', $user->id)->where('task_status', 0)->get();
        return view('responsable.task.index', compact('tasks_done', 'tasks_not_done'));
    }

    public function create(){
        $responsables=User::all();
        $clients=Client::all();
        return view('admin.tasks.create' , compact('responsables','clients'));
    }

    public function createR(){
        $responsables=User::all();
        $clients=Client::all();
        return view('responsable.task.create' , compact('responsables','clients'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required' ],
            'description'=>['required'],
            'date_end'=>['required' , 'date'],
        ]);
        $insert=new Task();

        $insert->name = $request->name;
        $insert->description = $request->description;
        $insert->date_end = $request->date_end;
        $insert->client_id = $request->client_id;
        $insert->responsable_id = $request->responsable_id;
        if (Auth::check()) {
            $insert->admin_id = Auth::id();
        }
        // if(Auth::id()){
        //     $insert->user_id=Auth::user()->id;
        // }
        $insert->save();
        return redirect('admin/tasks')->with('success', 'task created successfully.');
    }

    public function storeR(Request $request){
        $request->validate([
            'name'=>['required' ],
            'description'=>['required'],
            'date_end'=>['required' , 'date'],
        ]);
        $insert=new Task();

        $insert->name = $request->name;
        $insert->description = $request->description;
        $insert->date_end = $request->date_end;
        $insert->client_id = $request->client_id;
        $insert->responsable_id = $request->responsable_id;
        if (Auth::check()) {
            $insert->admin_id = Auth::id();
        }
        // if(Auth::id()){
        //     $insert->user_id=Auth::user()->id;
        // }
        $insert->save();
        return redirect('respo/tasks')->with('success', 'task created successfully.');
    }

    public function updateTaskStatus($id)
    {
        $task = Task::find($id);

        if (!$task) {
            // Gérer le cas où la tâche n'est pas trouvée
            abort(404);
        }

        // Mettre à jour le statut de la tâche
        $task->update(['task_status' => 1]);

        // Rediriger ou effectuer d'autres actions après la mise à jour
        return redirect()->back();
    }

    public function adminHome()
    {
        return view('admin.home');
    }
    public function respoHome()
    {
        return view('responsable.home');
    }
}

