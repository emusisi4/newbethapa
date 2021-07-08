<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Cintransfer;
use App\Branchcashstanding;
class CashbalanceController extends Controller
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
     
    
    
     
    
       // return   Cintransfer::with(['branchName','branchNamefrom','ceratedUserdetails','approvedUserdetails', 'statusName'])->latest('id')
       return   Branchcashstanding::with(['branchName'])->latest('id')
      // return   Madeexpense::latest('id')
      // ->where('branchto', $userbranch)
       ->paginate(25);
     
    
     

      
    }

    
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
        'branchnametobalance'   => 'required',
        'description'   => 'required',
        'amount'  => 'required',
        'transferdate'  => 'required',
      
       // 'expensetype'   => 'sometimes |min:0'
     ]);

     $dateinact = $request['transferdate'];
     $yearmade = date('Y', strtotime($dateinact));
     $monthmade = date('m', strtotime($dateinact));


     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;

  
     
  //       $dats = $id;
       return Cintransfer::Create([
      'branchto' => $request['branchnametobalance'],
      'branchfrom' => $userbranch,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'transferdate' => $request['transferdate'],
      'monthmade' =>  $monthmade,
      'yearmade' =>  $yearmade,
      
 
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
        //
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


/// updating the collections wallet
$cplbal  = \DB::table('expensewalets')->where('id', 1)->value('bal');
$newbaldddd = $cplbal-$amount;
$reseokkl = \DB::table('expensewalets')->where('id', 1)->update(['bal' =>  $newbaldddd]);


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



}
