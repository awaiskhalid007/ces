<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projectstatus;
use App\Models\Archeivereason;


class statusesController extends Controller
{
    public function prjectStatusPage()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{

            $user = User::where('email', $email)->get();
            $id = $user[0]->id;

            $statuses = Projectstatus::where('user_id', $id)->orderBy('sort', 'asc')->get();
            $statuses_count = Projectstatus::where('user_id', $id)->get()->count();

            $reasons = Archeivereason::where('user_id', $id)->orderBy('sort', 'asc')->get();
            $reasons_count = Archeivereason::where('user_id', $id)->get()->count();

            return view('dashboard.project-status',[
            'user'              =>      $user, 
            'statuses'          =>      $statuses, 
            'statuses_count'    =>      $statuses_count, 
            'reasons'           =>      $reasons, 
            'reasons_count'     =>      $reasons_count
        ]);
        
        }
    }
    // public function getAllStatuses()
    // {
    //     $email = session()->get('email');
    

    //     $user = User::where('email', $email)->get();

    //     $statuses = Projectstatus::orderBy('sort', 'asc')->get();
    //     $statuses_count = Projectstatus::get()->count();

    //     // $reasons = Archeivereason::orderBy('id', 'asc')->get();
    //     // $reasons_count = Archeivereason::get()->count();

    //     return $statuses;
    
    // }
    public function prjectStatusadd(Request $request)
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $validate = $request->validate([
            'status' => 'required | min:2 | max:20',
            'color' => 'required | min:3 | max:7',
            'user_id' => 'required'
            ]);

            $statuses = Projectstatus::orderBy('sort', 'desc')->get();
            if(!$statuses->isEmpty()){
                $latestsort = $statuses[0]->sort;
                $sortvalue = $latestsort+1;
            }else{
                $sortvalue = 1;
            }
            $status              =        $request->status;
            $color               =        $request->color;
            $user_id             =        $request->user_id;

            if($color=="")
            {
                $color = "#333333";
            }
            $array = [
                'status'         =>      $status,
                'color'          =>      $color,
                'user_id'        =>      $user_id,
                'sort'           =>      $sortvalue,
            ];
            Projectstatus::create($array);
            return redirect('/setup/project-status');
        }

    }
    public function delete_status($id){
        Projectstatus::where('id', $id)->delete();
        return redirect()->back();
    }
    public function update_status(Request $request)
    {
        $status = $request->name;
        $id = $request->id;
        $color = $request->color;
        if($color == "")
        {
            $color = "#333333";
        }

        Projectstatus::where('id',$id)->update(['status'=>$status,'color'=>$color]);
        return redirect('setup/project-status');

    }
    // Status Sorting
    public function statusSortUp(Request $request){
        $id = $request->id;
        $data = Projectstatus::find($id);
        $position = $data->sort;
        if($position > 1)
        {
            $new = $position-1;
            $alter = Projectstatus::where('sort', $new)->get();
            if($alter->isEmpty()){
                Projectstatus::where('id', $id)->update(['sort'=>$new]);
                return 1;
            }else{
                $alter_id = $alter[0]->id;
                Projectstatus::where('id', $alter_id)->update(['sort'=>$position]);
                Projectstatus::where('id', $id)->update(['sort'=>$new]);
                return 1;
            }
        }else{
            return 1;
        }
    }
    public function statusSortDown(Request $request){
        $id = $request->id;
        $data = Projectstatus::find($id);
        $position = $data->sort;
        if($position >= 1)
        {
            $new = $position+1;
            $alter = Projectstatus::where('sort', $new)->get();
            if($alter->isEmpty()){
                Projectstatus::where('id', $id)->update(['sort'=>$new]);
                return 1;
            }else{
                $alter_id = $alter[0]->id;
                Projectstatus::where('id', $alter_id)->update(['sort'=>$position]);
                Projectstatus::where('id', $id)->update(['sort'=>$new]);
                return 1;
            }
        }elseif($position <= 1){
            return 1;
        }
    }

    public function prjectReasonadd(Request $request)
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $validate = $request->validate([
            'reason' => 'required | min:2 | max:20',
            'color' => 'required | min:3 | max:7',
            'user_id' => 'required'
            ]);

            $reasons = Archeivereason::orderBy('sort', 'desc')->get();
            if(!$reasons->isEmpty()){
                $latestsort = $reasons[0]->sort;
            }else{
                $latestsort = 0;
            }   
            $sortvalue           =       $latestsort + 1;
            $reason              =        $request->reason;
            $color               =        $request->color;
            $user_id             =        $request->user_id;

            if($color == "")
            {
                $color = "#333333";
            }

            $array = [
                'reason'         =>      $reason,
                'color'          =>      $color,
                'user_id'        =>      $user_id,
                'sort'           =>      $sortvalue,
            ];
            Archeivereason::create($array);
            return redirect('/setup/project-status');
        }

    }
    public function delete_reason($id){
        Archeivereason::where('id', $id)->delete();
        return redirect()->back();
    }
    public function update_reason(Request $request)
    {
        $reason = $request->reason;
        $id = $request->id;
        $color = $request->color;
        if($color == "")
        {
            $color = "#333333";
        }

        Archeivereason::where('id',$id)->update(['reason'=>$reason,'color'=>$color]);
        return redirect('setup/project-status');

    }
    public function reasonsSort(Request $reqest){
        $id = $reqest->id;
        $flag = $reqest->flag;

        if($flag == 'UP'){
            $data = Archeivereason::find($id);
            $position = $data->sort;
            if($position > 1)
            {
                $new = $position-1;
                $alter = Archeivereason::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Archeivereason::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Archeivereason::where('id', $alter_id)->update(['sort'=>$position]);
                    Archeivereason::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }else{
                return 1;
            }
        }elseif($flag == 'DOWN')
        {
            $data = Archeivereason::find($id);
            $position = $data->sort;
            if($position >= 1)
            {
                $new = $position+1;
                $alter = Archeivereason::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Archeivereason::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Archeivereason::where('id', $alter_id)->update(['sort'=>$position]);
                    Archeivereason::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }elseif($position <= 1){
                return 1;
            }
        }
    }

}