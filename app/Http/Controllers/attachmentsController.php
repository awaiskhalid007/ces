<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use DB;

class attachmentsController extends Controller
{
    public function index($salt)
    {
    	$project_salt = $salt;
    	$project = Project::where('salt', $project_salt)->get();
        $project_id = $project[0]->id;
        $project_name = $project[0]->name;
    	return view('dashboard.project-attachments',['project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name]);

    }
    public function upload(Request $request)
    {
    	$project_id = $request->id;
    	$file = $request->file;
    	$name = $file->getClientOriginalName();
        $timestamp = Carbon::now()->toDateTimeString();
        $ext = $file->getClientOriginalExtension();
    	$size = $file->getSize(); //bytes
    	$size = number_format($size / 1048576,2); //MB'S
    	if($size > 25)
    	{
    		return 'sizeError';
    	}
    	$session = session()->get('email');
    	$user = DB::select("SELECT * FROM users WHERE email='$session'");
    	$user_id = $user[0]->id;

    	$new_name = uniqid(rand(99, 99999)).date('m-y-d').rand(1,100).'.'.$ext;

    	$path = public_path('img/attachments/');
    	move_uploaded_file($file, $path.$new_name);

    	DB::insert("INSERT INTO attachments (name, file, user_id, project_id, created_at, updated_at) VALUES ('$name','$new_name','$user_id','$project_id','$timestamp','$timestamp')");
    	return "Uploaded";
    }
    public function fetching_attachments(Request $request)
    {
        $id = $request->project_id;
        $query = DB::select("SELECT * FROM attachments WHERE project_id='$id'");
        $data = '';
        if(empty($query))
        {
            $data = "<tr><td class='text-center' colspan='4' style='padding-top:20px;padding-bottom:20px;'>No record found.</td></tr>";
        }else{
            foreach($query as $item){
                $data .= '
                <tr>
                    <td><img src="img/attachments/'.$item->file.'" class="img-fluid" width="30px"/></td>
                    <td>'.$item->name.'</td>
                    <td>'.date('d M, Y', strtotime($item->created_at)).'</td>
                    <td>
                        <a href="/attachment/'.$item->id.'/'.$item->project_id.'/delete"><i class="fa fa-trash fa-sm text-info"></i></a>
                    </td>
                </tr>';
            }
        }

        return $data;

    }
    public function delete($id, $project_id)
    {
        $query = DB::delete("DELETE FROM attachments WHERE id='$id' AND project_id='$project_id'");
        return back();
    }
}	
