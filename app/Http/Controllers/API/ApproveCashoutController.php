<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;

use App\Couttransfer;
use App\Branchcashstanding;

class ApproveCashoutController extends Controller
{
  
  
    public function __construct()
    {
       $this->middleware('auth:api');
      //  $this->authorize('isAdmin'); 
    }

    public function index()
    {
      $userid =  auth('api')->user()->id;
    $userbranch =  auth('api')->user()->branch;
    $userrole =  auth('api')->user()->mmaderole;



      
       return   Couttransfer::with(['branchName','branchNamefrom','ceratedUserdetails'])->latest('id')
       //  return   Couttransfer::latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
       ->paginate(13);

      //  if($userrole == '103')
      //  {      
      //     return   Cintransfer::with(['branchName','branchNamefrom','ceratedUserdetails','approvedUserdetails', 'statusName'])->latest('id')
      //    //  return   Cintransfer::latest('id')
      //   // return   Madeexpense::latest('id')
      //   ->where('branchto', $userbranch)
      //    ->paginate(20);
      //  }
    }

   
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
        'branchnametobalance'   => 'required | String |max:191',
        'description'   => 'required',
        'amount'  => 'required',
        'transferdate'  => 'required',
      
       // 'expensetype'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;

  
     
  //       $dats = $id;
       return Couttransfer::Create([
      'branchto' => $request['branchnametobalance'],
      'branchfrom' => $userbranch,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'transferdate' => $request['transferdate'],
      
 
      'ucret' => $userid,
    
  ]);
    }

 
    
    public function show($id)
    {
        //
    }
   
    
    
    public function update(Request $request, $id)
    {
        //
        $user = Madeexpense::findOrfail($id);

$this->validate($request,[
    'expense'   => 'required | String |max:191',
    'description'   => 'required',
    'amount'  => 'required',
    'datemade'  => 'required',
    'branch'  => 'required'
]);

 
     
$user->update($request->all());
    }

  
    public function destroy($id)
    {
        $userid =  auth('api')->user()->id;
        $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->mmaderole;

      
        //
     //   $this->authorize('isAdmin'); 

     //   $id = Couttransfer::findOrFail($id);
      //  $user->delete();
      
$branchinact = \DB::table('couttransfers')->where('id', '=', $id)->value('branchto');
$amountrecieved = \DB::table('couttransfers')->where('id', '=', $id)->value('amount');


$existanceofbranch = \DB::table('branchcashstandings')->where('branch', '=', $branchinact)->count();



      $currentdate = date("Y-m-d H:i:s");
if($existanceofbranch < 1)
{
 Branchcashstanding::Create([
    'branch' => $branchinact,
    'outstanding' => $amountrecieved,
    //'outstanding' => 0,
    //'ucret' => $userid,
  
]);

DB::table('couttransfers')
->where('id', $id)
->update(['status' => '1', 'comptime' => $currentdate, 'ucomplete' => $userid]);

}


      if($existanceofbranch > 0)
      {
        $currentbalance = \DB::table('branchcashstandings')->where('branch', '=', $branchinact)->value('outstanding');
        $newbalance = $currentbalance + $amountrecieved;
      /// checking to make sure that the amount is not less than the collected amount
     // if($newbalance >= 0)
      {
        /// Updating the shop cash
      DB::table('branchcashstandings')
      ->where('branch', $branchinact)
      ->update(['outstanding' => $newbalance]);
      /// Updating the transfers
      DB::table('couttransfers')->where('id', $id)->update(['status' => '1', 'comptime' => $currentdate, 'ucomplete' => $userid]);

      }
      
      
    }

































     
       // return['message' => 'user deleted'];

    }



}
