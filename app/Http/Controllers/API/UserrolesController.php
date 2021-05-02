<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Role;

class UserrolesController extends Controller
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
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;

      if($userrole == 900)
      {
    //  return   Product::with(['userbalancingBranch','branchinBalance'])->latest('id')
   // return   Productcategory::with(['brandName','productCategory','productSupplier','unitMeasure'])->latest('id')
      return   Role::latest('id')
       //  return   Branchpayout::latest('id')
        // ->where('branch', $userbranch)
        ->paginate(20);
      }


     if($userrole != 900)
      {
      
      
     // return   Product::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      return   Role::latest('id')
       //  return   Branchpayout::latest('id')
         ->where('roleid','!=', '900')
         ->where('roleid','!=', '100')
        ->paginate(20);
      
    }
      
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
        'rolename'   => 'required',
        'branch'   => 'required',
        'description'   => 'required'
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;

  $datepaid = date('Y-m-d');
//  $inpbranch = $request['branchnametobalance'];
$roleid  = Role::orderBy('id', 'Desc')->limit(1)->value('roleid');
$newroleid = $roleid+1;
$dateinq =  $request['datedone'];


       return Role::Create([
    

      'rolename' => $request['rolename'],
      'sysname' => $request['sysname'],
      'description' => $request['description'],
      'type' => $request['type'],
      'mmaderole' => $request['rolename'],
      'roleid' => $newroleid,
     
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
        $user = Role::findOrfail($id);

$this->validate($request,[
//  'catname'   => 'required  |max:191'
  

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
     //   $this->authorize('isAdmin'); 
        $user = Role::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
