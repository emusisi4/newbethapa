<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Thecomponent;
use App\Formcomponent;
class ComponentfeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
      //  $this->authorize('isAdmin'); 
    }

    public function index()
    {
        $userid =  auth('api')->user()->id;
       

    
        return   Formcomponent::latest('id')
   
        ->paginate(13);




        
    }

   
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];
       $this->validate($request,[
    'featurename'   => 'required  |max:191',
     'sysname'   => 'required',
  
    'description'   => 'required'
     ]);
     $userid =  auth('api')->user()->id;
     
     
     
     return Formcomponent::Create([
      'featurename' => $request['featurename'],
      'sysname' => $request['sysname'],
     
      'description' => $request['description'],
     
      'ucret' => $userid,
     
  ]);
    }

    public function show($id)
    {
        //
    }
    public function profile()
    {
        return auth('api')->user();
    }
    
    
    public function update(Request $request, $id)
    {
        //
        $user = Formcomponent::findOrfail($id);

    $this->validate($request,[
    'featurename'   => 'required |max:191',
     'sysname'   => 'required',
  
    'description'   => 'required'
    ]);


$user->update($request->all());
    }

  
    
    public function destroy($id)
    {
        //
      // $this->authorize('isAdmin'); 
     //  $this->authorize('isSuperadmin'); 

        $user = Formcomponent::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
