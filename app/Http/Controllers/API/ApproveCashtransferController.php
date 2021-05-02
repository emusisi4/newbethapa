<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;

use App\Couttransfer;
use App\Branchcashstanding;
use App\Userbalance;
class ApproveCashtransferController extends Controller
{
 
    
    public function __construct()
    {
       $this->middleware('auth:api');
      //  $this->authorize('isAdmin'); 
    }

    public function index()
    {
      //$userid =  auth('api')->user()->id;
     // $userbranch =  auth('api')->user()->branch;
      //$userrole =  auth('api')->user()->type;
     //   if($userrole = 1)



      
        return   Couttransfer::with(['branchName','branchNamefrom','ceratedUserdetails'])->latest('id')
       //  return   Couttransfer::latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
       ->paginate(13);

      
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
      //$userrole =  auth('api')->user()->type;
        //
     //   $this->authorize('isAdmin'); 

     //   $id = Couttransfer::findOrFail($id);
      //  $user->delete();
      ///$year = date('Y', strtotime($dateString));
      
$userrecieving = \DB::table('cashtransfers')->where('id', '=', $id)->value('transferto');
$amountrecieved = \DB::table('cashtransfers')->where('id', '=', $id)->value('amount');
$sentfrom = \DB::table('cashtransfers')->where('id', '=', $id)->value('transferfrom');
/// cgetting the current Amount for the Person who sent
$transferamount = $amountrecieved;
$sendersbalance  = Userbalance::where('username', $userid)->value('amount');

$userrecievingexistance = \DB::table('userbalances')->where('username', '=', $userrecieving)->count();


$currentdate = date("Y-m-d H:i:s");



/// checking if the sending user still Has the amount on wallet
if($sendersbalance >= $transferamount)
{

if($userrecievingexistance < 1)
{
    Userbalance::Create([
    'username' => $userrecieving,
    'outstanding' => $amountrecieved,
    //'outstanding' => 0,
    //'ucret' => $userid,
  
]);

DB::table('cashtransfers')
->where('id', $id)
->update(['status' => '1', 'comptime' => $currentdate, 'ucomplete' => $userid]);

}


      if($userrecievingexistance > 0)
      {
        $currentbalance = \DB::table('userbalances')->where('username', '=', $userrecieving)->value('amount');
        $newbalance = $currentbalance + $amountrecieved;
      /// checking to make sure that the amount is not less than the collected amount
     // if($newbalance >= 0)
      {
        /// Updating the shop cash
      DB::table('userbalances')
      ->where('username', $userrecieving)
      ->update(['amount' => $newbalance]);
      /// Updating the transfers
      DB::table('cashtransfers')->where('id', $id)->update(['status' => '1', 'comptime' => $currentdate, 'ucomplete' => $userid]);

      }
      
      
    }

  }//closing if the senders balance is there
  if($sendersbalance < $transferamount)
  {
    Userbalancehhhhhhh::Create([
     // 'username' => $userrecieving,
     // 'outstanding' => $amountrecieved,
      //'outstanding' => 0,
      //'ucret' => $userid,
    
  ]);
  }  






























     
       // return['message' => 'user deleted'];

    }



}
