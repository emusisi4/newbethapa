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
use App\Branchpayout;

class BranchpayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
 $this->middleware('auth:api');
//       $this->authorize('isAdmin'); 
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

     $currentdate = date("Y-m-d");
     if($userrole == "101")
     {
      return   Branchpayout::with(['ExpenseTypeconnect','expenseCategory','payingUserdetails'])->latest('id')
     //  return   Branchpayout::latest('id')
        ->where('del', 0)
        ->where('bpaying', $userbranch)
        ->where('datepaid', $currentdate)
       ->paginate(13);
     }

     if($userrole != '101')
     {
    //  $this->authorize('isAdmin'); 
      return   Branchpayout::with(['ExpenseTypeconnect','expenseCategory','payingUserdetails'])->latest('datepaid')
     //  return   Branchpayout::latest('id')
        ->where('del', 0)
      //  ->where('bpaying', $userbranch)
       // ->where('datepaid', $currentdate)
       ->paginate(13);
     }

     
       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           










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

/*
  $this->validate($request,[
        'receiptno'   => 'required | String |max:191',
        'datemade'   => 'required',
        'branchpayingtheticket' => 'required',
        'branch'  => 'required',
        'amount'  => 'required'
        //'amount'   => 'sometimes |min:0'
     ]);

*/
$userid =  auth('api')->user()->id;
$userbranch =  auth('api')->user()->branch;
$userrole =  auth('api')->user()->type;
if($userrole == '101')
{
       $this->validate($request,[
        'receiptno'   => 'required | String |max:191',
        'datemade'   => 'required',
       // 'branchpayingtheticket' => 'required',
        'branch'  => 'required',
        'amount'  => 'required'
        //'amount'   => 'sometimes |min:0'
     ]);

$amo = $request['amount'];
     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
   //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
   //  $hid = $id1+1;

  $datepaid = date('Y-m-d');
     
  //       $dats = $id;
       Branchpayout::Create([
      'receiptno' => $request['receiptno'],
      'bpaying' =>  $userbranch,
      'datemade' => $request['datemade'],
      'branch' => $request['branch'],
      'amount' => $request['amount'],
      'datepaid' => $datepaid,
      'paymentdate' => $datepaid,
     // 'mainheadercategory' => $request['mainheadercategory'],
 
      'ucret' => $userid,
    
  ]);
  $amounttoupdate = $amo;
  $thewalletbalance = \DB::table('branchcashstandings')->where('branch', $userbranch )->value('outstanding');
 
  
  $newbal = $thewalletbalance-$amo;
  $result009 = \DB::table('branchcashstandings')->where('branch', $userbranch)->update(['outstanding' =>  $newbal]);
        
       }/// closing the if
       if($userrole != '101')
       {
              $this->validate($request,[
               'receiptno'   => 'required | String |max:191',
               'datemade'   => 'required',
               'branchpayingtheticket' => 'required',
               'datepaidd' => 'required',
               'branch'  => 'required',
               'amount'  => 'required'
               //'amount'   => 'sometimes |min:0'
            ]);
       
       $inactionbranch = $request['branch'];
            $userid =  auth('api')->user()->id;
            $userbranch =  auth('api')->user()->branch;
          //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
          //  $hid = $id1+1;
            
         $datepaid = date('Y-m-d');
            
         //       $dats = $id;
              return Branchpayout::Create([
             'receiptno' => $request['receiptno'],
             'bpaying' =>  $request['branchpayingtheticket'],
             'datemade' => $request['datemade'],
             'branch' => $request['branch'],
             'amount' => $request['amount'],
             'datepaid' => $request['datepaidd'],
             'paymentdate' => $request['datepaidd'],
            // 'mainheadercategory' => $request['mainheadercategory'],
        
             'ucret' => $userid,
           
         ]);
         //////////////////////////////////////////////////////
         $amounttoupdate = $request['amount'];
 $thewalletbalance = \DB::table('branchcashstandings')->where('branch', $inactionbranch )->value('outstanding');

 
 $newbal = $thewalletbalance-$amounttoupdate;
 $result2 = \DB::table('branchcashstandings')->where('branch', $inactionbranch)->update(['outstanding' =>  $newbal]);
       
              }/// closing the if
       



    }

   
    public function show($id)
    {
        //
    }
    public function Branchtotalsd()
    {
        //getSinglebranchpayoutdaily
        $ed = '0';
      //  return Branchpayout::where('del',0)->sum('amount');
      return   Branchpayout::latest('id')
      //  return   Branchpayout::latest('id')
         ->where('del', 0);
     //  ->paginate(13);
 
    }
   
    
    public function update(Request $request, $id)
    {
        //
        $user = Branchpayout::findOrfail($id);

        $this->validate($request,[
            'receiptno'   => 'required | String |max:191',
            'datemade'   => 'required',
            'branch'  => 'required',
            'amount'  => 'required'
    ]);

 
     
$user->update($request->all());
    }

  
    
     public function destroy($id)
    {
      

      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
/// gettinyg the transaction details
      $branchthatpaid = \DB::table('branchpayouts')->where('id', $id)->value('bpaying');
      $amountpaidout = \DB::table('branchpayouts')->where('id', $id)->value('amount');
    //  $approvalstate = \DB::table('madeexpenses')->where('id', $id )->value('approvalstate');
      //$walletofexpense = \DB::table('madeexpenses')->where('id', $id )->value('walletexpense');
    //  if($approvalstate == '1')
      {
       $thewalletbalance = \DB::table('branchcashstandings')->where('branch', $branchthatpaid )->value('outstanding');
       
       $newbal = $thewalletbalance+$amountpaidout;
       $result2 = \DB::table('branchcashstandings')->where('branch', $branchthatpaid)->update(['outstanding' =>  $newbal]);
       $user = Branchpayout::findOrFail($id);
       $user->delete();
      }
     
    //   if($approvalstate != '1')
    //   {
    //    // $thewalletbalance = \DB::table('expensewalets')->where('id', $walletofexpense )->value('bal');
    //    // $expenseamount = \DB::table('madeexpenses')->where('id', $id)->value('amount');
    //    // $newbal = $thewalletbalance+$expenseamount;
    //    // $result2 = \DB::table('expensewalets')->where('id', $walletofexpense)->update(['bal' =>  $newbal]);
    //    $user = Madeexpense::findOrFail($id);
    //    $user->delete();
    //   }
    //  //   $this->authorize('isAdmin'); 

    //     $user = Branchpayout::findOrFail($id);
    //     $user->delete();
    //    // return['message' => 'user deleted'];

    }
}
