<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Takeofflabel;
use App\Models\User;


class takeofflabelsController extends Controller
{
    public function takeLabelPage()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{

            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $labels = Takeofflabel::where('user_id', $user_id)->orderBy('sort', 'asc')->get();
            $labels_count = Takeofflabel::get()->count();
            return view('dashboard.takeoff-labels',[
                'user'              =>      $user, 
                'labels'            =>      $labels, 
                'labels_count'      =>      $labels_count,
            ]);
	        // return $labels_count;
            // $dbname = $user[0]->name;
        }
    }
    public function prjectLabeladd(Request $request)
    {
        $validate = $request->validate([
            'label' => 'required | min:2 | max:20',
            'color' => 'required | min:3 | max:7',
            'user_id' => 'required'
            ]);
            
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{

            $labels = Takeofflabel::orderBy('sort', 'desc')->get();
            if(!$labels->isEmpty()){
                $latestsort = $labels[0]->sort;
            }else{
                $latestsort = 0;
            }

            $sortvalue           =       $latestsort + 1;
            $label               =        $request->label;
            $color               =        $request->color;
            $user_id             =        $request->user_id;
            if($color == "")
            {
                $color = "#333333";
            }
            $array = [
                'label'          =>      $label,
                'color'          =>      $color,
                'user_id'        =>      $user_id,
                'sort'           =>      $sortvalue,
            ];
            Takeofflabel::create($array);
            return redirect('/setup/takeoff-label');
        }

    }
    public function update_label(Request $request)
    {
        $label      =       $request->label;
        $id         =       $request->id;
        $color      =       $request->color;
        if($color == "")
        {
            $color = "#333333";
        }
        Takeofflabel::where('id',$id)->update(['label'=>$label,'color'=>$color]);
        return redirect('setup/takeoff-label');
        return 1;

    }
    public function delete_label($id){
        $data = Takeofflabel::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function labelsSort(Request $request){
        $id = $request->id;
        $flag = $request->flag;

        if($flag == 'UP'){
            $data = Takeofflabel::find($id);
            $position = $data->sort;
            if($position > 1)
            {
                $new = $position-1;
                $alter = Takeofflabel::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Takeofflabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Takeofflabel::where('id', $alter_id)->update(['sort'=>$position]);
                    Takeofflabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }else{
                return 1;
            }
        }elseif($flag == 'DOWN')
        {
            $data = Takeofflabel::find($id);
            $position = $data->sort;
            if($position >= 1)
            {
                $new = $position+1;
                $alter = Takeofflabel::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Takeofflabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Takeofflabel::where('id', $alter_id)->update(['sort'=>$position]);
                    Takeofflabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }elseif($position <= 1){
                return 1;
            }
        }
    }
}
