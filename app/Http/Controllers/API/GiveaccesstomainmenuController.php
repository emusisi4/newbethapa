<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;

use App\Componentsaccesse;
use App\Rolenaccmain;

class GiveaccesstomainmenuController extends Controller
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

      if($userrole == '101')
      {
      return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      // return   Shopbalancingrecord::latest('id')
       //  return   Branchpayout::latest('id')
         ->where('branch', $userbranch)
        ->paginate(20);
      }


      if($userrole == '100')
      {
      
      
      return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      // return   Shopbalancingrecord::latest('id')
       //  return   Branchpayout::latest('id')
         ->where('del', 0)
        ->paginate(20);
      
    }
      
    }

   
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];
       $userid =  auth('api')->user()->id;
       $userbranch =  auth('api')->user()->branch;
       $userrole =  auth('api')->user()->type;
 


       $this->validate($request,[
      'roleformainmenuaccess'   => 'required |max:191',
       'mainmenus'   => 'required'
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $roleee = $request['roleformainmenuaccess'];
     $compo =  $request['mainmenus'];
     DB::table('rolenaccmains')->where('roleto', $roleee)->where('component', $compo)->delete();
       return Rolenaccmain::Create([
      'roleto' => $request['roleformainmenuaccess'],
      'component' => $request['mainmenus'],


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
        $user = branch::findOrfail($id);

$this->validate($request,[
  'branchname'   => 'required | String |max:191'
  

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

        $user = Rolenaccmain::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
