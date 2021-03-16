<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Projectstatus;
use App\Models\Projectlabel;
use App\Models\Takeofflabel;
use App\Models\Archeivereason;
use App\Models\Project_Plan;
use App\Models\Billing;
use App\Models\Stage;
use App\Models\Measurement;
use App\Models\Project_Todo;
use App\Models\Attachment;
use App\Models\Template;
use App\Models\Template_Todo;
use App\Models\TakeoffTemplate;
use App\Models\Invitation;
use App\Models\Symbol;
use App\Models\SymbolCategory;
use App\Models\Sharing;


use Illuminate\Support\Facades\Crypt;
use DB;

class adminController extends Controller
{
    public function admin_login(Request $request){

    	$session = $request->session()->get('adminEmail');
    	if ($session == '') {
         return view('admin.login'); 
    	}else{
          return redirect('dashboard/all-users');
       }
    	   	
    }
   	public function admin_logined(Request $request){

   		$request->validate([
   			'email' => 'required | email',
   			'password' => 'required'
   		]);

   		$email = $request->email;
   		$password = $request->password;
   		$db_user = User::where('email', $email)->get();
     		if (!$db_user->isEmpty()) {
     			$db_pass = $db_user[0]->password;
       			if (password_verify($password, $db_pass)) {
         				if ($db_user[0]->admin_status == 1) {
           					$request->session()->put('adminEmail', $email);
        	    			return redirect('/dashboard/all-users')->withErrors('loginSuccess');
         				}else{
         					return back()->withErrors('InvalidAdmin');
         				}
         			}else{
         				return back()->withErrors('PassError');
       			}
       		}else{
       			return back()->withErrors('EmailError');
     		}
   	}
   	public function admin_logout(Request $request){
   		$request->session()->forget('adminEmail');
   		return redirect('admin-login');
   	}
    public function all_users(Request $request){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $db_users = User::orderBy('id','desc')->get();
          $i = 1;
          return view('admin.index',['users' => $db_users,'i' => $i]);
         }
        
    }
    public function userBilling_details(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $billing = Billing::where('user_id', $id)->get();
          if($billing[0]->number != null || $billing[0]->number != ''){
            $billing[0]->number = Crypt::decryptString($billing[0]->number);
            }
            if($billing[0]->expiry != null || $billing[0]->expiry != ''){
                $billing[0]->expiry = Crypt::decryptString($billing[0]->expiry);
            }
            if($billing[0]->cvv != null || $billing[0]->cvv != ''){
                $billing[0]->cvv = Crypt::decryptString($billing[0]->cvv);
            }
          return view('admin.userBilling_details',['data' => $billing]);
        }
    }
    public function userproject_statues_details(Request $request, $id){
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $statuses = Projectstatus::where('user_id', $id)->get();
          $i = 1;
          return view('admin.userProject-Status',['data' => $statuses, 'i'=> $i]);
        }
    }
    public function userarchieve_reason_details(Request $request, $id){
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $archived_reasons = Archeivereason::where('user_id', $id)->get();
          $i = 1;
          return view('admin.userProject-ArcheiveReasons',['data' => $archived_reasons, 'i'=> $i]);
        }
    }
    public function userProjectReason_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Archeivereason::where('id', $id)->delete();
           return back();
          }
      }
    public function userproject_labels_details(Request $request, $id){
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $labels = Projectlabel::where('user_id', $id)->get();
          $i = 1;
          return view('admin.userProject-label',['data' => $labels, 'i'=> $i]);
        }
    }
     public function userProjectLabel_delete(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          Projectlabel::where('id',$id)->delete();
          return back();
         }
    }
    public function usertake_off_labels_details(Request $request, $id){
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $takeoff_labels = Takeofflabel::where('user_id', $id)->get();
          $i = 1;
          return view('admin.userProject-Takeoff-label',['data' => $takeoff_labels, 'i'=> $i]);
        }
    }
    public function userTakeoffLabel_delete(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          Takeofflabel::where('id',$id)->delete();
          return back();
         }
    }
    public function user_delete(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{

          User::where('id',$id)->delete();
          Billing::where('user_id', $id)->delete();
          Archeivereason::where('user_id', $id)->delete();
          Attachment::where('user_id', $id)->delete();
          Project::where('user_id', $id)->delete();
          Project_Plan::where('user_id', $id)->delete();
          Project_Todo::where('user_id', $id)->delete();
          Projectlabel::where('user_id', $id)->delete();
          sharing::where('user_id', $id)->delete();
          symbol::where('user_id', $id)->delete();
          Stage::where('user_id', $id)->delete();
          SymbolCategory::where('user_id', $id)->delete();
          takeofflabel::where('user_id', $id)->delete();
          TakeoffTemplate::where('user_id', $id)->delete();
          Template::where('user_id', $id)->delete();
          Template_Todo::where('user_id', $id)->delete();

          return back();
         }
    }
    public function user_update(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $user_details = User::where('id', $id)->get();
          return view('admin.update_users',['user_details' => $user_details]);
         }
      
    }
    public function user_updated(Request $request, $id){

      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $request->validate([
            'name' => 'required',
            'licences' => 'required',
            'email' => 'required | email',
            ]);
            $name = $request->name;
            $company = $request->company;
            $phone = $request->phone;
            $licences = $request->licences;
            $email = $request->email;
            DB::Update("UPDATE users SET name=?, company=?, phone=?, email=?, licences=? WHERE id=?",[$name, $company, $phone, $email, $licences, $id]);
            return redirect('dashboard/all-users');
               }
      
    }
    public function change_password(Request $request)
    { 
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          return view('admin.change_password');
         }
      
    }
    public function changed_password(Request $request)
    {
      // return $request;
      $email = $request->session()->get('adminEmail');
        if ($email == '') {
           return redirect('/admin-login'); 
        }else{
          $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confermPassword' => 'required',
            ]);

            $old_Password = $request->oldPassword;
            $new_Password = $request->newPassword;
            $conferm_Password = $request->confermPassword;
            $db_user = User::where('email', $email)->get();
            $user_id = $db_user[0]->id;
            $user_password = $db_user[0]->password;
            if (password_verify($old_Password, $user_password)) {
                if ($new_Password == $conferm_Password) {
                  $password = bcrypt($new_Password);
                  DB::Update("UPDATE users SET password=? WHERE id=? ",[$password, $user_id]);
                  return back()->withErrors('Success');
                }else{
                  return back()->withErrors('passNotMatched');
              }
            }else{
                return back()->withErrors('WrongPass');
              }
         }
    }
    public function active_projects(Request $request)
    {
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $status = 1;
          $data = array();
          $active_projects = Project::where('status', $status)->get();
        //   return $active_projects;
          foreach($active_projects as $obj)
          {
  
            $user_id = $obj->user_id;
            $user = User::where('id', $user_id)->get();
            if ($user->isEmpty()){
                $user_name = null;
            }else{
                 $user_name = $user[0]->name;
            }
           
            $list = ['id'=>$obj->id,'user_name'=>$user_name, 'name'=>$obj->name, 'description'=> $obj->description, 'client'=>$obj->client, 'date'=>$obj->created_at];

            array_push($data, $list);
          }

          return view('admin.active_projects',['active_projects' => $data]);
         }
    }
    public function archived_projects(Request $request)
    {
        $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $status = 2;
          $data = array();
          $archived_projects = Project::where('status', $status)->get();
          foreach($archived_projects as $obj)
          {
            $user_id = $obj->user_id;
            $user = User::find($user_id);
            $user_name = $user->name;
            $list = ['id'=>$obj->id,'user_name'=>$user_name, 'name'=>$obj->name, 'description'=> $obj->description, 'client'=>$obj->client, 'date'=>$obj->created_at];

            array_push($data, $list);
          }

          return view('admin.archived_projects',['archived_projects' => $data]);
         }
    }
    public function trashed_projects(Request $request)
    {
      $session = $request->session()->get('adminEmail');
        if ($session == '') {
           return redirect('/admin-login'); 
        }else{
          $status =   0;
          $data = array();
          $trashed_projects = Project::where('status', $status)->get();
          foreach($trashed_projects as $obj)
          {
            $user_id = $obj->user_id;
            $user = User::find($user_id);
            $user_name = $user->name;
            // return $obj;
            $list = ['id'=>$obj->id,'user_name'=>$user_name, 'name'=>$obj->name, 'description'=> $obj->description, 'client'=>$obj->client, 'date'=>$obj->created_at];

            array_push($data, $list);
          }

          return view('admin.trashed_projects',['trashed_projects' => $data]);
         }
      }
      public function activeProjects_delete(Request $request, $id){

        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project::where('id', $id)->delete();
            return back();
          }
      }
      public function archivedProjects_delete(Request $request, $id){

        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project::where('id', $id)->delete();
            return back();
          }
      }
      public function trashedProjects_delete(Request $request, $id){

        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project::where('id', $id)->delete();
            return back();
          }
      }
      public function add_admin(Request $request){

          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            return view('admin.add_user');
          }
      }
      public function added_admin(Request $request){

          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $request->validate([
              'name' => 'required',
              'email' => 'required | email | unique:users',
              'password' => 'required',
            ]);

            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $b_password = bcrypt($password);
            $licences = 1;   
            $timezone = 'America/New_York';
            $type = '1';  // Administrator
            $status = '1'; // 0 For Invited Users (Pending)
            $admin_status = 1;
            $subscription = '0';
            $subscription_paid = '0';
            $trial = '1';

            User::create(['name'=>$name,'email'=>$email,'password'=>$b_password, 'timezone'=>$timezone,'licences'=>$licences, 'type'=>$type, 'status'=>$status, 'admin_status' => $admin_status,'subscription'=>$subscription,'subscription_paid'=>$subscription_paid,'trial'=>$trial,]);
            return redirect('/dashboard/all-users');
          }
      }
      public function activeProject_details(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $data = array();
            foreach ($project_details as $obj) {
              $id = $obj->user_id;
              $status_id = $obj->status_id;
              $label_id = $obj->label_id;
              $status_details = Projectstatus::where('id', $status_id)->get();
              if (!$status_details->isEmpty()) {
                $color = $status_details[0]->color;
                $status = $status_details[0]->status;
              }else{
                $color = null;
                $status = null;
              }
              $label_details = Projectlabel::where('id', $label_id)->get();
              if (!$label_details->isEmpty()) {
                $label_color = $label_details[0]->color;
                $label = $label_details[0]->label;
              }else{
                $label_color = '#333333';
                $label = 'Not Available';
              }
              
              $project_name = $obj->name;
              $description = $obj->description;
              $client_name = $obj->client;
              $created_at = $obj->created_at;

              $user = User::where('id', $id)->get();
              $username = $user[0]->name;

              $val = ['id' => $id,'username' => $username,'project_name' => $project_name,'description' => $description,'client_name' => $client_name,'created_at' => $created_at, 'color' => $color, 'status' => $status,'label' => $label, 'label_color' => $label_color];

              array_push($data, $val);
            }
            return view('admin.activeProject_details',['data' => $data]);
          }
      }
      public function activeProject_todos(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Project_Todo::where('project_id', $id)->get();
            return view('admin.activeProject_todos', ['data' => $todos]);
          }
      }
       public function archivedProject_todos(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Project_Todo::where('project_id', $id)->get();
            return view('admin.archivedProject_todos', ['data' => $todos]);
          }
      }
       public function trashedProject_todos(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Project_Todo::where('project_id', $id)->get();
            return view('admin.trashedProject_todos', ['data' => $todos]);
          }
      }
      public function activeProjectTodo_delete(Request $request, $id)
      {
         $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project_Todo::where('id', $id)->delete();
            return back();
          }
      }
       public function archivedProjectTodo_delete(Request $request, $id)
      {
         $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project_Todo::where('id', $id)->delete();
            return back();
          }
      }
       public function trashedProjectTodo_delete(Request $request, $id)
      {
         $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Project_Todo::where('id', $id)->delete();
            return back();
          }
      }
      public function activeProject_stages(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Stage::where('project_id', $id)->get();
            return view('admin.activeProject_stages', ['data' => $todos]);
          }
      }
      public function archivedProject_stages(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Stage::where('project_id', $id)->get();
            return view('admin.archivedProject_stages', ['data' => $todos]);
          }
      }
      public function trashedProject_stages(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Stage::where('project_id', $id)->get();
            return view('admin.trashedProject_stages', ['data' => $todos]);
          }
      }
      public function activeProject_attachments(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Attachment::where('project_id', $id)->get();
            return view('admin.activeProject_attachments', ['data' => $todos]);
          }
      }
      public function archivedProject_attachments(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Attachment::where('project_id', $id)->get();
            return view('admin.archivedProject_attachments', ['data' => $todos]);
          }
      }
      public function trashedProject_attachments(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $todos = Attachment::where('project_id', $id)->get();
            return view('admin.trashedProject_attachments', ['data' => $todos]);
          }
      }
       public function archivedProject_details(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $data = array();
            foreach ($project_details as $obj) {
              $id = $obj->user_id;
              $status_id = $obj->status_id;
              $label_id = $obj->label_id;
              $archived_reason_id = $obj->archive_reasons_id;
              $status_details = Projectstatus::where('id', $status_id)->get();
              if (!$status_details->isEmpty()) {
                $color = $status_details[0]->color;
                $status = $status_details[0]->status;
              }else{
                   $color = null;
                   $status = null;
              }
              $archived_reason = Archeivereason::where('id', $archived_reason_id)->get();
              $reason_color = $archived_reason[0]->color;
              $reason = $archived_reason[0]->reason;

              $label_details = Projectlabel::where('id', $label_id)->get();
              if (!$label_details->isEmpty()) {
                $label_color = $label_details[0]->color;
                $label = $label_details[0]->label;
              }else{
                $label_color = '#333333';
                $label = 'Not Available';
              }
              
              $project_name = $obj->name;
              $description = $obj->description;
              $client_name = $obj->client;
              $created_at = $obj->created_at;

              $user = User::where('id', $id)->get();
              $username = $user[0]->name;

              $val = ['id' => $id,'username' => $username,'project_name' => $project_name,'description' => $description,'client_name' => $client_name,'created_at' => $created_at, 'color' => $color, 'status' => $status,'label' => $label, 'label_color' => $label_color, 'reason' => $reason, 'reason_color' => $reason_color];
              
              array_push($data, $val);
            }
            return view('admin.archivedProject_details',['data' => $data]);
          }
      }
       public function trashedProject_details(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_details = Project::where('id', $id)->get();
            $data = array();
            foreach ($project_details as $obj) {
              $id = $obj->user_id;
              $status_id = $obj->status_id;
              $label_id = $obj->label_id;
              $status_details = Projectstatus::where('id', $status_id)->get();
              $color = $status_details[0]->color;
              $status = $status_details[0]->status;

              $label_details = Projectlabel::where('id', $label_id)->get();
              if (!$label_details->isEmpty()) {
                $label_color = $label_details[0]->color;
                $label = $label_details[0]->label;
              }else{
                $label_color = '#333333';
                $label = 'Not Available';
              }
              
              $project_name = $obj->name;
              $description = $obj->description;
              $client_name = $obj->client;
              $created_at = $obj->created_at;

              $user = User::where('id', $id)->get();
              $username = $user[0]->name;

              $val = ['id' => $id,'username' => $username,'project_name' => $project_name,'description' => $description,'client_name' => $client_name,'created_at' => $created_at, 'color' => $color, 'status' => $status,'label' => $label, 'label_color' => $label_color];
              
              array_push($data, $val);
            }
            return view('admin.trashedProject_details',['data' => $data]);
          }
      }
      public function activeProject_plans(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           $plans =  Project_Plan::where('project_id', $id)->get();
           return view('admin.activeProject_plans',['plan' => $plans]);
          }
      }
      public function archivedProject_plans(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           $plans =  Project_Plan::where('project_id', $id)->get();
           return view('admin.archivedProject_plans',['plan' => $plans]);
          }
      }
       public function trashedProject_plans(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           $plans =  Project_Plan::where('project_id', $id)->get();
           return view('admin.trashedProject_plans',['plan' => $plans]);
          }
      }
      public function activeProjectPlan_delete(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Project_Plan::where('id', $id)->delete();
           return back();
          }
      }
      public function archivedProjectPlan_delete(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Project_Plan::where('id', $id)->delete();
           return back();
          }
      }
       public function trashedProjectPlan_delete(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Project_Plan::where('id', $id)->delete();
           return back();
          }
      }
      public function activeProject_worksheet(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $stage = Stage::where('project_id', $id)->get();
            $data = array();

            foreach($stage as $obj){
              $stage_name = $obj->name;
              $stage_id = $obj->id;
              $measurement = Measurement::where('stage_id', $stage_id)->get();
              $additional_items = DB::select("SELECT * From additional_items WHERE stage_id= '$stage_id' ORDER BY 1 DESC");
              $val = ['stage_name' => $stage_name, 'stage_id' => $stage_id, 'additional_items' => $additional_items, 'measurement' => $measurement];
              array_push($data, $val);
            }
            return view('admin.activeProject_worksheet', ['data' => $data]);
          }
      }
       public function archivedProject_worksheet(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $stage = Stage::where('project_id', $id)->get();
            $data = array();

            foreach($stage as $obj){
              $stage_name = $obj->name;
              $stage_id = $obj->id;
              $measurement = Measurement::where('stage_id', $stage_id)->get();
              $additional_items = DB::select("SELECT * From additional_items WHERE stage_id= '$stage_id' ORDER BY 1 DESC");
              $val = ['stage_name' => $stage_name, 'stage_id' => $stage_id, 'additional_items' => $additional_items, 'measurement' => $measurement];
              array_push($data, $val);
            }
            return view('admin.archivedProject_worksheet', ['data' => $data]);
          }
      }
       public function trashedProject_worksheet(Request $request, $id)
      {
          $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $stage = Stage::where('project_id', $id)->get();
            $data = array();

            foreach($stage as $obj){
              $stage_name = $obj->name;
              $stage_id = $obj->id;
              $measurement = Measurement::where('stage_id', $stage_id)->get();
              $additional_items = DB::select("SELECT * From additional_items WHERE stage_id= '$stage_id' ORDER BY 1 DESC");
              $val = ['stage_name' => $stage_name, 'stage_id' => $stage_id, 'additional_items' => $additional_items, 'measurement' => $measurement];
              array_push($data, $val);
            }
            return view('admin.trashedProject_worksheet', ['data' => $data]);
          }
      }
      public function userProjectStatus_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            Projectstatus::where('id', $id)->delete();
           return back();
          }
      }
      public function activeProjectStage_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Stage::where('id', $id)->delete();
           return back();
          }
      }
      public function archivedProjectStage_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Stage::where('id', $id)->delete();
           return back();
          }
      }
      public function trashedProjectStage_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Stage::where('id', $id)->delete();
           return back();
          }
      }
      public function activeProjectAttachment_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Attachment::where('id', $id)->delete();
           return back();
          }
      }
      public function archivedProjectAttachment_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Attachment::where('id', $id)->delete();
           return back();
          }
      }
      public function trashedProjectAttachment_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Attachment::where('id', $id)->delete();
           return back();
          }
      }
//======== templates active/trashed ===== 
      public function projectTemplate_user(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $project_template = Template::where('user_id', $id)->orderBy('id', 'desc')->get();
            // return $project_template;
           $data = array();
           foreach ($project_template as $obj) {
             $temp_id = $obj->id;
             $user_id = $obj->user_id;
             $status = $obj->status;
             $created_at = $obj->created_at;
             $temp_name = $obj->name;
            
             $val = ['temp_id' => $temp_id, 'temp_name' => $temp_name, 'status' => $status, 'created_at' => $created_at];
            array_push($data, $val);
           }
           // return $data;
           return view(' admin.user_templateProject',['data' => $data]);
          }
       
      }
      public function tempProject_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Template::where('id', $id)->delete();
           return back();
          }
      }
      public function tempProject_stage(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
          $temp_stage =  Stage::where('template_id', $id)->get();
          return view('admin.tempActiveProject_stages',['data' => $temp_stage]);
          }
      }
       public function tempProjectStage_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
           Stage::where('id', $id)->delete();
           return back();
          }
      }
       
       public function tempProject_todos(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $active_todo = Template_Todo::where('template_id', $id)->orderBy('id', 'desc')->get();
            $data = array();
            foreach ($active_todo as $obj) {
              $name = $obj->name;
              $id = $obj->id;
              $tasks =  DB::select("SELECT * FROM template_todo_tasks WHERE todo_id = '$id' ORDER BY 1 DESC");
              $val = ['name' => $name, 'id' => $id, 'tasks' => $tasks];
              array_push($data, $val);
            }
            return view('admin.tempActiveProject_todos', ['data' => $data]);
          }
      }
      public function tempProjectTodo_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
          DB::delete("DELETE FROM template_todo_tasks WHERE id='$id'");   
          return back();
          }
      }
      // Takeoff- Templates 
      public function takeoffTemplate_user(Request $request, $id)
      {
         $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
            $takeoffTemp = TakeoffTemplate::where('user_id', $id)->orderBy('id', 'desc')->get();
            $data = array();
            foreach ($takeoffTemp as $obj) {
              $id = $obj->id;
              $name = $obj->name;
              $created_by = $obj->user_id;
              $status = $obj->status;
              $created_at = $obj->created_at;
              $label_id = $obj->takeoff_label_id;
              
              $takeoff_label = Takeofflabel::where('id', $label_id)->get();
              if (!$takeoff_label->isEmpty()) {
                  $label_name = $takeoff_label[0]->label;
                  $label_color = $takeoff_label[0]->color;  
              }else{
                  $label_name = null;
                  $label_color = null;
              }

              $val = ['id' => $id, 'name' => $name, 'label_name' => $label_name, 'label_color' => $label_color  , 'created_at' => $created_at, 'status' => $status];
              array_push($data, $val);           
            }
          return view('admin.usertakeoff_Templates',['data' => $data]);
          }
      }
      public function takeoffTemplate_delete(Request $request, $id)
      {
        $session = $request->session()->get('adminEmail');
          if ($session == '') {
             return redirect('/admin-login'); 
          }else{
          TakeoffTemplate::where('id', $id)->delete();
          return back();
          }
      }
     

}









