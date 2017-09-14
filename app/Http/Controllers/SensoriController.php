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

class SensoriController extends Controller
{

	public function SensoriHandle($site_id){

		$Sensori=DB::table('sensori')
		->where('ambiente','=', $site_id)
		->get();



		return view('/userviews/sensori_handle',compact('Sensori','site_id'));
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

	public function Detection($id_sensore){

		$detections =DB::table('rilevazioni')
		->where('id_sensore','=', $id_sensore)
		->get();
		return view('/userviews/detection', compact('detections'));

	}

}
