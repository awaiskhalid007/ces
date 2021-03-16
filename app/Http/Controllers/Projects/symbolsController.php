<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SymbolCategory;
use App\Models\Symbol;
use Validator;
use DB;

class symbolsController extends Controller
{
    public function mySymbolsPage(){
		  $session = session()->get('email');
    	if($session == "")
    	{
    		return redirect('/login');
    	}else{
    		$user = User::where('email',$session)->get();
    		$user_id = $user[0]->id;
    		$categories = SymbolCategory::where('user_id',$user_id)->orderBy('id', 'desc')->get();
        $data = array();

        foreach($categories as $cat)
        {
          $id = $cat->id;
          $name = $cat->name;
          $pack = $cat->pack;
          $symbols = Symbol::where('category', $id)->get();
          $item = ['id'=>$id,'name'=>$name,'pack'=>$pack,'symbols'=>$symbols];
          array_push($data, $item);
        }

        $packs = SymbolCategory::where([
          ['user_id', '=' ,$user_id],
          ['pack', '!=' ,null]
        ])->get();
        $default_packs = DB::select("SELECT * FROM default_packs ORDER BY 1 DESC");
        $available_packs = array();
        foreach($default_packs as $o)
        {
          $pack_name = $o->name;
          $count = SymbolCategory::where('pack', $pack_name)->get()->count();
          if($count == 0)
          {
            $n = ucfirst($pack_name);
            $item = ['name'=>$n, 'pack'=>$pack_name];
            array_push($available_packs, $item); 
          }
        }  

    		return view('dashboard.setup-symbols',['data'=>$data,'packs'=>$packs,'available_packs'=> $available_packs]);
    	}
    }

    // Add Category
    public function addCategory(Request $request)
    {
    	$email = session()->get('email');
    	$user = User::where('email',$email)->get();
    	$user_id = $user[0]->id;
    	$name = $request->name;
    	SymbolCategory::create(['name'=> $name, 'user_id'=>$user_id]);
    	return back()->withErrors('categoryadded');
    }
    //Edit Category Name
    public function editCategoryName(Request $request)
    {
      $name = $request->name;
      $id = $request->id;

      SymbolCategory::where('id', $id)->update(['name'=> $name]);
      return redirect('/setup/symbols')->withErrors('categoryupdated');
    }
    public function deleteCategory(Request $request)
    {
      $id = $request->id;
      $data = SymbolCategory::find($id);
      $data->delete();
      return redirect('/setup/symbols')->withErrors('categorydeleted');
    }
    // Add Symbol
    public function addSymbol(Request $request)
    {
    	$cat_id = $request->category;
    	$file = $request->file;

    	$email = session()->get('email');
    	$user = User::where('email',$email)->get();
    	$user_id = $user[0]->id;
   		
   		$validation = Validator::make($request->all(), [
	      'file' => 'required|image|mimes:jpeg,png,jpg,gif,bmp|max:8000'
	     ]);
   		$filename = $file->getClientOriginalName();
   		$new_name = date('Y-m-d').'.'.uniqid(rand(999, 999999)) . '.' . $file->getClientOriginalExtension();
   		$path = "img/symbols/".$new_name;
   		if(move_uploaded_file($file, $path))
   		{
   			Symbol::create(['name'=>$filename,'category'=>$cat_id,'user_id'=>$user_id,'image'=>$new_name]);
   			return redirect('/setup/symbols');
   		}else{
   			return back()->withErrors('imguploadError');
   		}
    }
    public function install_pack(Request $request)
    {
      $pack = $request->val;
      $session = $request->session()->get('email');
      $user = User::where('email', $session)->get();
      $user_id = $user[0]->id;
      $name = ucfirst($pack);
      $check = SymbolCategory::where('pack', $pack)->get()->count();
      if($check == 0)
      {
        SymbolCategory::create(['name'=>$name, 'user_id'=>$user_id,'pack'=>$pack]);
      }
      return 1;
    }
}
