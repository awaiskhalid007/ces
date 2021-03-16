<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Template;
use App\Models\Projectstatus;
use App\Models\Projectlabel;
use App\Models\Archeivereason;
use App\Models\Project_Todo;
use App\Models\Project_Plan;
use App\Models\Template_Todo;
use Carbon\Carbon;
use DB;

class Template_todosController extends Controller
{
    public function store_todo(Request $request)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $template_id     =    $request->id;
            $name           =    $request->name;
            $userid         =    $user_id;

            $request->validate([
                'name'     =>      'required | min:3 | max:30',
            ]);
            $array = [
                'name'          =>      $name,
                'template_id'   =>      $template_id,
                'user_id'       =>      $userid
            ];
            Template_Todo::create($array);
            return redirect()->back();
        }
    }
    public function update_todo(Request $request)
    {
    	$session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $name = $request->name;
            // $assign_to = $request->assign_to;
            $id = $request->id;

            $request->validate([
                'name'     =>      'required | min:1 | max:30',
            ]);
            Template_Todo::where('id', $id)->update(['name' => $name]);
              
            return redirect()->back();
        }
    }
    public function delete_todo(Request $request)
    {
    	$todo_id = $request->id;
        DB::delete("DELETE FROM template_todo_tasks WHERE todo_id='$todo_id'");
        $data = Template_Todo::find($todo_id);
        $data->delete();
        return 1;
    }
    public function add_todo_task(Request $request)
    {
        $validate = $request->validate([
            'name'=>'required',
            'todo_id'=>'required',
        ]);
        $name = $request->name;
        $todo_id = $request->todo_id;

        DB::insert("INSERT INTO template_todo_tasks (name, todo_id) VALUES ('$name', '$todo_id')");
        return back();
    }
    public function rename_todo_task(Request $request)
    {
       $id = $request->id;
       $name = $request->name;
       
       DB::update("UPDATE template_todo_tasks SET name='$name' WHERE id='$id'");
       return back();
    }
    public function delete_todo_task(Request $request)
    {
       $id = $request->id;
       DB::delete("DELETE FROM template_todo_tasks WHERE id='$id'");
       return 1;
    }
    public function clear_todo_tasks(Request $request)
    {
        $todo_id = $request->id;
        DB::delete("DELETE FROM template_todo_tasks WHERE todo_id='$todo_id'");
        return 1;
    }

}
