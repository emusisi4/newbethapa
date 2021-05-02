<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Formcomponent;

class FormcomponentsController extends Controller
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
       

     //   $this->authorize('isSuperadmin'); 
      //  return   Thecomponent::with(['userRole','userBranch'])->latest('id')
      return   Formcomponent::latest('id')
       // ->where('del', 0)
       ->paginate(30);




        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];
       $this->validate($request,[
    'featurename'   => 'required | String |max:191',
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function profile()
    {
        return auth('api')->user();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = Formcomponent::findOrfail($id);

$this->validate($request,[
    'featurename'   => 'required | String |max:191',
    'sysname'   => 'required',
    'description'   => 'sometimes |min:2'

    ]);


$user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
