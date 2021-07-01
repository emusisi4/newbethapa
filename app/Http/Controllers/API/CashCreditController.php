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
use App\Couttransfer;

class CashCreditController extends Controller
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
     //   if($userrole = 1)





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();


     if($userrole == '101')
     {      
        return   Couttransfer::with(['branchName','branchNamefrom','ceratedUserdetails','approvedUserdetails', 'statusName'])->latest('id')
       //  return   Cintransfer::latest('id')
      // return   Madeexpense::latest('id')
        ->where('branchto', $userbranch)
       ->paginate(13);
     }
     if($userrole == '100')
     {      
        return   Couttransfer::with(['branchName','branchNamefrom','ceratedUserdetails','approvedUserdetails', 'statusName'])->latest('id')
       //  return   Cintransfer::latest('id')
      // return   Madeexpense::latest('id')
        ->where('del', 0)
       ->paginate(13);
    }
    if($userrole != '100' || $userrole != '101') 
    {      
       return   Couttransfer::with(['branchName','branchNamefrom','ceratedUserdetails','approvedUserdetails', 'statusName'])->latest('id')
      //  return   Cintransfer::latest('id')
     // return   Madeexpense::latest('id')
       ->where('del', 0)
      ->paginate(13);
   }

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

     $dateinact = $request['transferdate'];
     $yearmade = date('Y', strtotime($dateinact));
     $monthmade = date('m', strtotime($dateinact));
     
  //       $dats = $id;
       return Couttransfer::Create([
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
     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
   $userrole =  auth('api')->user()->mmaderole;
   $mywallet =  auth('api')->user()->branch;


   $amountrecieved = \DB::table('couttransfers')->where('id', '=', $id)->value('amount');
   $transactiondate = \DB::table('couttransfers')->where('id', '=', $id)->value('transferdate');
   $branchinaction = \DB::table('couttransfers')->where('id', '=', $id)->value('branchto');
   $status = \DB::table('couttransfers')->where('id', '=', $id)->value('status');

   $gettintthewalletbalance = \DB::table('branchcashstandings')->where('branch', '=', $branchinaction)->value('outstanding');

if($status == '1')
{
  $transferamount  = \DB::table('couttransfers')->where('id', '=', $id)->value('amount');
$newtrans = \DB::table('couttransfers')->where('id', '=', $id)->value('transactionno');

$currentwalletbalance  = \DB::table('branchcashstandings')->where('branch', '=', $branchinaction)->value('outstanding');
$newbalance = $currentwalletbalance-$transferamount;
DB::table('branchcashstandings')
->where('branch', $branchinaction)
->update(['outstanding' => $newbalance]);

////////
$user = Couttransfer::findOrFail($id);
$user->delete();
}
if($status != '1')
{
        $user = Couttransfer::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];
}

    }



}
