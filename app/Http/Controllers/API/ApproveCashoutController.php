<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use App\Accounttransaction;

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
      $mywallet =  auth('api')->user()->mywallet;
      
        //
     //   $this->authorize('isAdmin'); 
$transactionno = Str::random(20);
   
     
$amountrecieved = \DB::table('couttransfers')->where('id', '=', $id)->value('amount');
$transactiondate = \DB::table('couttransfers')->where('id', '=', $id)->value('transferdate');
$currentdate = date("Y-m-d H:i:s");


$gettintthewalletbalance = \DB::table('expensewalets')->where('id', '=', $mywallet)->value('bal');
if($gettintthewalletbalance >= $amountrecieved)
{

  DB::table('couttransfers')->where('id', $id)->update(['status' => '1', 'comptime' => $currentdate, 'transactionno' => $transactionno, 'ucomplete' => $userid]);
/////////////////////////////////////////
$transferamount  = \DB::table('couttransfers')->where('id', '=', $id)->value('amount');
$newtrans = \DB::table('couttransfers')->where('id', '=', $id)->value('transactionno');
$currentwalletbalance  = \DB::table('expensewalets')->where('id', '=', $mywallet)->value('bal');
$newbalance = $currentwalletbalance-$transferamount;
DB::table('expensewalets')
->where('id', $mywallet)
->update(['bal' => $newbalance]);

/// Updating the transaction
Accounttransaction::Create([
  'transactiondate' => $transactiondate,
'transactionno' => $newtrans,
  'transactiontype' => 1,
  'amount' => $amountrecieved,
  'walletinaction' => $mywallet,
  'accountresult'=> $newbalance,
  'ucret' => $userid,
  'description' => 'Branch Credit',
  //'yearmade' => $yearmade,
 // 'monthmade' => $monthmade,
  

]);
}

}

}
