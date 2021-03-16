<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\TakeoffTemplate;
use App\Models\Template_Todo;
use App\Models\User;
use App\Models\Stage;
use App\Models\Sharing;
use App\Http\Controllers\emailsController;
use DB; 

class templatesController extends Controller
{
    public function index()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $status = 1;

            $sharing = Sharing::where('user_id',$user_id)->get();
            if($sharing->count() > 0){
                $template_salt = $sharing[0]->template_salt;
                $shared_templates = Template::where('salt', $template_salt)->get();
            }else{
                $shared_templates = '';
            }
            
            
            $templates = Template::where(['user_id' => $user_id, 'status' => $status])->orderBy('id','desc')->get();
            return view('dashboard.templates-main',['templates'=>$templates,'shared_templates'=>$shared_templates]);
        }
    }
    public function create(Request $request){
        function generate_salt($len = 12)
        {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789$_';
            $l = strlen($chars) - 1;
            $str = '';
            for ($i = 0; $i < $len; ++$i) {
                $str .= $chars[rand(0, $l)];
            }
            return $str;
        }
        $name = $request->name;
        $email = $request->session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $id = $user[0]->id;
            $salt_query = Template::orderBy('created_at','desc')->first();
            if($salt_query != null){
                $salt_id = $salt_query->id;
            }else{
                $salt_id = 1;
            }
            $salt = generate_salt().$salt_id.generate_salt();
            Template::create(['name'=>$name, 'user_id'=>$id,'salt'=>$salt, 'status' => 1]);
            return redirect('/project-templates/open');
        }
    }
    public function update(Request $request)
    {
        $name = $request->name;
        $id = $request->id;
        
        Template::where('id', $id)->update(['name'=>$name]);
        return back();
    }
    public function duplicate(Request $request)
    {
        function generate_salt($len = 12)
        {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789$_';
            $l = strlen($chars) - 1;
            $str = '';
            for ($i = 0; $i < $len; ++$i) {
                $str .= $chars[rand(0, $l)];
            }
            return $str;
        }
        $temp_id = $request->id;
        
        $email = $request->session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $id = $user[0]->id;
            
            $old = Template::find($temp_id);

            $name = $old->name.' - Copy';

            $salt_query = Template::orderBy('created_at','desc')->first();
            if($salt_query != null){
                $salt_id = $salt_query->id;
            }

            $salt = generate_salt().$salt_id.generate_salt();
            Template::create(['name'=>$name, 'user_id'=>$id,'salt'=>$salt, 'status' => 1]);
            return redirect('/project-templates/open');
        }
    }
    public function delete($id)
    {
        // $salt = $request->salt;
        // $temp = Template::where('salt',$salt)->get();
        // $id = $temp[0]->id;
        // $data = Template::find($id);
        // $data->delete();
        // return back();
        $status = 0;
        Template::where('id', $id)->update(['status'=>$status]);
        return back();
    }
    public function trash_index()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $status = 0;
            $templates = Template::where(['user_id' => $user_id, 'status' => $status])->get();
            return view('dashboard.templates-trash',['templates'=>$templates]);
        }
    }
    public function restore($id)
    {
        $status = 1;
        Template::where('id', $id)->update(['status'=>$status]);
        return back();
    }
    public function template_todo($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $data = array();
            $status = 0;
            $template_salt = $salt;
            $template_details = Template::where(['salt' => $template_salt, 'user_id' => $user_id])->get();
            $template_id = $template_details[0]->id;
            $template_name = $template_details[0]->name;
            $todo_list = Template_Todo::where(['template_id' => $template_id, 'user_id' => $user_id])->get();
            foreach($todo_list as $t)
            {
                $id = $t->id;
                $name = $t->name;
                $tasks = DB::select("SELECT * FROM template_todo_tasks WHERE todo_id='$id'");
                $item = ['id'=>$id, 'name'=>$name,'tasks'=>$tasks];
                array_push($data, $item);
            }
            return view('dashboard.template-todo', [
                'data'         => $data,
                'template_id'       => $template_id, 
                'template_name'     => $template_name,
                'template_salt'     => $template_salt
            ]);
        }
    }
    public function template_stages($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $template_salt = $salt;
            $template_details = Template::where(['salt' => $template_salt, 'user_id' => $user_id])->get();
            $template_id = $template_details[0]->id;
            $template_name = $template_details[0]->name;
            $stages = Stage::where('template_id', $template_id)->get();
            $takeoff_templates = TakeoffTemplate::where('user_id', $user_id)->get();

            return view('dashboard.template-stages', [
                'template_id'       => $template_id, 
                'template_name'     => $template_name,
                'template_salt'     => $template_salt,
                'stages'            => $stages,
                'takeoff_templates' => $takeoff_templates
            ]);
        }
    }
    public function template_sharing($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        $shared = Sharing::where([
            ['invited_by','=',$user_id],
            ['template_salt','=',$salt]
        ])->get();
        if($session == "")
        {
            return redirect('/login');
        }else{
            $template_salt = $salt;
            $template_details = Template::where(['salt' => $template_salt, 'user_id' => $user_id])->get();
            $template_id = $template_details[0]->id;
            $template_name = $template_details[0]->name;

            $count = $shared->count();
            $invitations = array();
            if($count > 0)
            {
                foreach($shared as $o)
                {
                    $id = $o->id;
                    $user_id = $o->user_id;
                    $invited_by = $o->invited_by;
                    $template_salt = $o->template_salt;
                    $status = $o->status;
                    
                    $getUser = User::find($user_id);
                    $user_id = $getUser->id;
                    $user_name = $getUser->name;
                    $user_email = $getUser->email;
                    $user_company = $getUser->company;

                    $getTemplate = Template::where('salt',$template_salt)->get();
                    $template_id = $getTemplate[0]->id;
                    $template_name = $getTemplate[0]->name;

                    $item = [
                        'user_id'=>$user_id, 'user_name'=>$user_name,'user_email'=>$user_email,'user_company'=>$user_company,'template_id'=>$template_id,'template_name'=>$template_name,'status'=>$status
                    ];

                    array_push($invitations, $item);
                }
            }

            return view('dashboard.template-sharing', [
                'template_id'       => $template_id, 
                'template_name'     => $template_name,
                'template_salt'     => $template_salt,
                'user'              => $user,
                'invitations'       => $invitations
            ]);
        }
    }
    public function search_email(Request $request)
    {
        $key = $request->value;
        $session = session()->get('email');
        $data = array();
        $users = DB::select("SELECT * FROM users WHERE email LIKE '%$key%'");
        return $users;
        foreach($users as $user){
            $email = $user->email;
            if($email != $session)
            {
                array_push($data, $user);
            }
        }
        return $data;
    }
    public function invite_user(Request $request)
    {
        $sessionEmail = $request->session()->get('email');
        $sUser = User::where('email', $sessionEmail)->get();
        $session_id = $sUser[0]->id;
        $status = 0;
        $id = $request->id;
        $user = User::find($id);
        $template_salt = $request->template_salt;
        $project_id = null;

        $check = Sharing::where([
            ['user_id','=',$id],
            ['invited_by','=',$session_id],
            ['template_salt','=',$template_salt]
        ])->get();

        $checkCount =  $check->count();
        if($checkCount == 0)
        {
            Sharing::create(['user_id'=>$id, 'invited_by'=>$session_id,'template_salt' =>$template_salt, 'status'=>$status]);
        }
        
        (new emailsController)->template_sharing_invitation($user->name,$user->email,$sUser[0]->name, $sUser[0]->email, $template_salt, $id, $session_id);

        // Send invite email
        return back()->withErrors('invited');
    }
    public function accept_invite($template_salt, $user_id, $invited_by)
    {
        $check = Sharing::where([
            ['user_id','=',$user_id],
            ['invited_by','=',$invited_by],
            ['template_salt','=',$template_salt]
        ])->update(['status'=>1]);

        $template = Template::where('salt',$template_salt)->get();
        $salt = $template[0]->salt;
        return redirect('/project-templates/open');
    }
}
