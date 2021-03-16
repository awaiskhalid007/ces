<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projectlabel;
class labelsController extends Controller
{
    public function prjectLabelPage()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{

            $user = User::where('email', $email)->get();
            $id = $user[0]->id;
            $labels = Projectlabel::where('user_id', $id)->orderBy('sort', 'asc')->get();
            $labels_count = Projectlabel::where('user_id', $id)->get()->count();

            return view('dashboard.project-labels',[
                'user'              =>      $user, 
                'labels'            =>      $labels, 
                'labels_count'      =>      $labels_count,
            ]);
            // $dbname = $user[0]->name;
        }
    }
    public function projectLabeladd(Request $request)
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
             $validate = $request->validate([
            'label' => 'required | min:2 | max:20',
            'color' => 'required | min:3 | max:7',
            'user_id' => 'required'
            ]);

            $labels = Projectlabel::orderBy('sort', 'desc')->get();
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
            Projectlabel::create($array);
            return redirect('/setup/project-label');
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
        Projectlabel::where('id',$id)->update(['label'=>$label,'color'=>$color]);
        return redirect('setup/project-label');

    }
    public function delete_label($id){
        Projectlabel::where('id', $id)->delete();
        return redirect()->back();
    }
    public function labelsSort(Request $request){
        $id = $request->id;
        $flag = $request->flag;

        if($flag == 'UP'){
            $data = Projectlabel::find($id);
            $position = $data->sort;
            if($position > 1)
            {
                $new = $position-1;
                $alter = Projectlabel::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Projectlabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Projectlabel::where('id', $alter_id)->update(['sort'=>$position]);
                    Projectlabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }else{
                return 1;
            }
        }elseif($flag == 'DOWN')
        {
            $data = Projectlabel::find($id);
            $position = $data->sort;
            if($position >= 1)
            {
                $new = $position+1;
                $alter = Projectlabel::where('sort', $new)->get();
                if($alter->isEmpty()){
                    Projectlabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }else{
                    $alter_id = $alter[0]->id;
                    Projectlabel::where('id', $alter_id)->update(['sort'=>$position]);
                    Projectlabel::where('id', $id)->update(['sort'=>$new]);
                    return 1;
                }
            }elseif($position <= 1){
                return 1;
            }
        }
    }
}

