<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Madeexpense;
use App\Cintransfer;
use App\Accounttransaction;


class DeletecashcollectionConroller extends Controller
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
    $userrole =  auth('api')->user()->type;
     //   if($userrole = 1)





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();

     if($userrole == '101')
      {
      
         return   Madeexpense::with(['branchName','expenseName'])->latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
        ->where('branch', $userbranch)
        ->where('explevel', 1)
       ->paginate(30);
      }
      if($userrole != '101')
      {
      
         return   Madeexpense::with(['branchName','expenseName'])->latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
       // ->where('branch', $userbranch)
       ->paginate(20);
      }

       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           

       return   Madeexpense::get()->count();








       // {
      // return Submheader::latest()
      //  -> where('ucret', $userid)
    //    ->paginate(15);
      //  }

      
    }

  
    public function store(Request $request)
    {
   
      

       $this->validate($request,[
        'expense'   => 'required | String |max:191',
        'description'   => 'required',
        'amount'  => 'required',
        'datemade'  => 'required',
        'branch'  => 'required',
       // 'expensetype'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $mywallet =  auth('api')->user()->mywallet;
     $dateinact = $request['datemade'];
     $yearmade = date('Y', strtotime($dateinact));
     $monthmade = date('m', strtotime($dateinact));
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;
     $exp = $request['expense'];
     $expcat = \DB::table('expenses')->where('expenseno', $exp )->value('expensecategory');
//$expcat =  Expense::where('id', $exp)->value('expensecategory');
     $exptyo = \DB::table('expenses')->where('expenseno', $exp)->value('expensetype');

  $approvalstate = \DB::table('expenses')->where('expenseno', $exp )->value('appstate');
  if($approvalstate == '1')
{
  $approvedstatus = 1;
}
if($approvalstate != '1')
{
  $approvedstatus = 0;
}
     $expenseamount = $request['amount'];
  //getting the wallet balance'
  $mywalletbalance = \DB::table('expensewalets')->where('id', $mywallet )->value('bal');
  if($mywalletbalance >= $expenseamount)
  {
       Madeexpense::Create([
      'expense' => $request['expense'],
     //'expenseno' => $hid,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'walletexpense' => $mywallet,
      'datemade' => $request['datemade'],
      'branch' => $request['branch'],
      'category' => $expcat,
      'exptype' => $exptyo,
      'yearmade' => $yearmade,
      'approvalstate' => $approvedstatus,
      'monthmade' => $monthmade,
      'ucret' => $userid,
    
  ]);

  //// Gettint the current wallet balance
  
  if($approvalstate == '1' )
  {
    $newwalletbalance  = $mywalletbalance-$expenseamount;
    $result2 = \DB::table('expensewalets')->where('id', $mywallet)->update(['bal' =>  $newwalletbalance]);

  }
 

} /// closing the if balance is enough to spend
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
        //
     //   $this->authorize('isAdmin'); 
     $userid =  auth('api')->user()->id;
     //   $this->authorize('isAdmin'); 
/////////////////////////////////////////////////////////////////////////////////////////////
$approvalstate = \DB::table('cintransfers')->where('id', $id )->value('status');
$walletdeducted = \DB::table('cintransfers')->where('id', $id )->value('branchto');
if($approvalstate == '1')
{
 $thewalletbalance = \DB::table('branchcashstandings')->where('branch', $walletdeducted )->value('outstanding');
 $amount = \DB::table('cintransfers')->where('id', $id)->value('amount');
 $newbal = $thewalletbalance+$amount;
 $result2 = \DB::table('branchcashstandings')->where('branch', $walletdeducted)->update(['outstanding' =>  $newbal]);
 $user = Cintransfer::findOrFail($id);
 $user->delete();
}

if($approvalstate != '1')
{
 // $thewalletbalance = \DB::table('expensewalets')->where('id', $walletofexpense )->value('bal');
 // $expenseamount = \DB::table('madeexpenses')->where('id', $id)->value('amount');
 // $newbal = $thewalletbalance+$expenseamount;
 // $result2 = \DB::table('expensewalets')->where('id', $walletofexpense)->update(['bal' =>  $newbal]);
 $user = Cintransfer::findOrFail($id);
 $user->delete();
}
 
}
   
//      $approvalstate = \DB::table('cintransfers')->where('id', $id )->value('status');
//      $usercreates = \DB::table('cintransfers')->where('id', $id )->value('ucret');
//      $walletrecieved = \DB::table('users')->where('id', $usercreates )->value('mywallet');
//      if($approvalstate == '1')
//      {
//       $thewalletbalance = \DB::table('expensewalets')->where('id', $walletrecieved )->value('bal');
//       $amountthatwasrecieved = \DB::table('cintransfers')->where('id', $id)->value('amount');
//       $newbal = $thewalletbalance-$amountthatwasrecieved;

//       $transactionno = \DB::table('cintransfers')->where('id', $id)->value('transactionno');
// /// deleting the account transaction
// DB::table('accounttransactions')->where('transactionno', $transactionno)->delete();
//       /// getting the latest balance for this account 
//       $latest = \DB::table('accounttransactions')->where('walletinaction', $walletrecieved)->orderBy('id', 'Desc')->limit(1)->value('accountresult');
//       $latestid = \DB::table('accounttransactions')->where('walletinaction', $walletrecieved)->orderBy('id', 'Desc')->limit(1)->value('id');
//       $newresultant = $latest-$amountthatwasrecieved;
// /// Updating the resultant
// $uoopsj = \DB::table('accounttransactions')->where('id', $latestid)->update(['accountresult' =>  $newresultant]);





//       $result2 = \DB::table('expensewalets')->where('id', $walletrecieved)->update(['bal' =>  $newbal]);
//       $user = Cintransfer::findOrFail($id);
//       $user->delete();
//      }
    
//      if($approvalstate != '1')
//      {
//       // $thewalletbalance = \DB::table('expensewalets')->where('id', $walletofexpense )->value('bal');
//       // $expenseamount = \DB::table('madeexpenses')->where('id', $id)->value('amount');
//       // $newbal = $thewalletbalance+$expenseamount;
//       // $result2 = \DB::table('expensewalets')->where('id', $walletofexpense)->update(['bal' =>  $newbal]);
//       $user = Cintransfer::findOrFail($id);
//       $user->delete();
//      }
      
      
//        // return['message' => 'user deleted'];

    }
}
