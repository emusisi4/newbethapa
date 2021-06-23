<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Cintransfer;
use App\Branchcashstanding;
use Illuminate\Support\Str;
use App\Accounttransaction;
class Approvefishcashin extends Controller
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





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();


      
        return   Cintransfer::with(['branchName','branchNamefrom','ceratedUserdetails'])->latest('id')
       //  return   Cintransfer::latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
       ->paginate(13);

       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           

    //   return   Cintransfer::get()->count();








       // {
      // return Submheader::latest()
      //  -> where('ucret', $userid)
    //    ->paginate(15);
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



    ////
  
     
  //       $dats = $id;
       return Cintransfer::Create([
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
      
        $mywallet =  auth('api')->user()->mywallet;
/////// checking if the branch exists in the cash details

$branchinact = \DB::table('cintransfers')->where('id', '=', $id)->value('branchto');
$amountrecieved = \DB::table('cintransfers')->where('id', '=', $id)->value('amount');
$currentdate = date("Y-m-d H:i:s");

$transactionno = Str::random(20);  
DB::table('cintransfers')
->where('id', $id)
->update(['status' => '1', 'comptime' => $currentdate, 'transactionno' => $transactionno, 'ucomplete' => $userid]);




$transferamount  = \DB::table('cintransfers')->where('id', '=', $id)->value('amount');
$transactiondate = \DB::table('cintransfers')->where('id', '=', $id)->value('transferdate');
$currentwalletbalance  = \DB::table('expensewalets')->where('id', '=', $mywallet)->value('bal');
$newtrans = \DB::table('cintransfers')->where('id', '=', $id)->value('transactionno');
$newbalance = $currentwalletbalance+$transferamount;
DB::table('expensewalets')
->where('id', $mywallet)
->update(['bal' => $newbalance]);


Accounttransaction::Create([
  'transactiondate' => $transactiondate,
  'transactionno' => $newtrans,
  'transactiontype' => 2,
  'amount' => $amountrecieved,
  'walletinaction' => $mywallet,
  'accountresult'=> $newbalance,
  'ucret' => $userid,
  'description' => 'Branch Collection',
  //'yearmade' => $yearmade,
 // 'monthmade' => $monthmade,
  

]);

     
    }




    

    
}
