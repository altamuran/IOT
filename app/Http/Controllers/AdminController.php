<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\User;
use \App\ambienti;
use Auth;


class AdminController extends Controller
{		
   
   public function __construct(){
        $this->middleware('auth');
    }


      public function AutHandle(){
            
          $Sens = \App\Sensori::all();
          $user = Auth::user();
            return view('/userviews/authandle', compact('Sens','user'));
    }

          public function UserHandle(){
            
          
            $all_user=DB::table('Users')
                ->where('accept','=', 1)
                ->get();
            $user = Auth::user();
            
            $flag=0;

            return view('/userviews/user_handle', compact('all_user','user','flag'));
    }


              public function SiteHandle($user_id){
                  $u=\App\User::find($user_id);

                  if(!is_null($u)){
                    $Sito=DB::table('ambienti')
                    ->where('user','=', $user_id)
                    ->get();  
                    }else

              return redirect()->action(
              'AdminController@UserHandle');


                $User=\App\User::find($user_id);
                
            return view('/userviews/site_handle',compact('Sito','User'));
    }


           public function SensoriHandle($site_id){

                 $Sensori=DB::table('sensori')
                ->where('ambiente','=', $site_id)
                ->get();

                
                
            return view('/userviews/sensori_handle',compact('Sensori','site_id'));
    }


     public function AddUser(){

      $all_user =DB::table('Users')
                ->where('accept','=', 0)
                ->get();
      
      
      return view('/userviews/adminpage',compact('all_user'));
    }

       public function Accept($user_id){

        $accept_user = \App\User::find($user_id);

        $accept_user->accept = 1;

        $accept_user->save();
         


      return redirect()->action(
    'AdminController@AddUser');

    }

    public function AddSite(){
     
      return view('/userviews/addsite');

    }



    public function AddSitePost(Request $request){

            
        

        $site= new \App\ambienti;
        $site->descrizione=$request->input('name');
        $site->user=$request->input('user');
        $site->save();

     return redirect()->route('sitehandle', ['id' => $request->input('user')]);

    }

        public function RemoveSite($request)
    {   

        $s = \App\ambienti::find($request);
        $s->delete();
        


         return back()->withInput();
    }

    public function AddSensore($site_id){

     $site=$site_id;
     
      return view('/userviews/addsensore',compact('site'));

    }

      public function AddNewSensore(Request $request){

        

        $sensore= new \App\Sensori;
        $sensore->tipo=$request->input('codice');
        $sensore->marca=$request->input('marca');
        $sensore->ambiente=$request->input('sito');
        $sensore->save();

        return redirect()->route('sensorihandle',$request->input('sito'));
    }

     public function RemoveSensore($request)
    {   
        
        $s = \App\Sensori::find($request);
        $ambiente= $s->ambiente;
        $s->delete();
        
        return redirect()->action(
    'AdminController@SensoriHandle',['site_id' => $ambiente]);
    }
    
      
       public function EditSensore($sensore_id,$site_id)
    {   
        $sensore=$sensore_id;
        $site=$site_id;

        return view('/userviews/editsensore',compact('sensore_id','site'));

    }

    public function Edit(Request $request)
    {   
        
        $s = \App\Sensori::find($request->input('id_sensore'));
        $ambiente= $s->ambiente;

        $s->tipo=$request->input('codice');
        $s->marca=$request->input('marca');
        $s->save();        
        
        return redirect()->action(
    'AdminController@SensoriHandle',['site_id' => $ambiente]);
    }
     
       public function Search(Request $request)
    {   
        

        $user = \App\User::find($request->ricerca);
        $flag=1;
        if( is_null($user))return redirect()->action(
    'AdminController@UserHandle',compact('flag'));
     
        
      return redirect()->action(
    'AdminController@SiteHandle',['user_id' => $user->id]);
    }  

    public function Detection($id_sensore){
           
        $detections =DB::table('rilevazioni')
                ->where('id_sensore','=', $id_sensore)
                ->get();



          return view('/userviews/detection', compact('detections'));

    }  


}
