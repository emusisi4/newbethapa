<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use Illuminate\Support\Facades\DB;
use App\Branch;
use App\Madeexpense;
use App\Branchstatement;

class BranchesController extends Controller
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
        //  $userid =  auth('api')->user()->id;
       

     //   $this->authorize('isSuperadmin'); 
     //   return   User::with(['userRole','userBranch'])->latest('id')
  return   Branch::latest('id')

  // ->where('del', 0)
  ->paginate(10);
    }

   
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
        'branchname'   => 'required | String |max:191'
       // 'iconclass'   => 'required',
       // 'dorder'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $id1  = Branch::latest('id')->orderBy('id', 'Desc')->limit(1)->value('id');
     $hid = $id1+1;

     $currentdatetime = date("Y-m-d H:i:s");
     $currentdate = date("Y-m-d");
  //       $dats = $id;
     Branch::Create([
      'branchname' => $request['branchname'],
     'branchno' => $hid,
      'location' => $request['location'],
      'contact' => $request['contact'],
     
 
      'ucret' => $userid,
    
  ]);


  Branchstatement::Create([
  'branchname' => $hid,
 
  'datedone' => $currentdate,
  'statementtype' => 'Account Openning',
  'statementstatus' => 'Credit',
  'transactionamount' => 0,
  'closingbalance' => $request['openningbalance'],


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

        $user = Branch::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
