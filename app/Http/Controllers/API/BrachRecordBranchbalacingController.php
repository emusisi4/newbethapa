<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Branchpayout;
use App\Branchtobalance;
use App\Shopbalancingrecord;

class BrachRecordBranchbalacingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
 //$this->middleware('auth:api');
      //  $this->authorize('isAdmin'); 
    }

    public function index()
    {
//$userid =  auth('api')->user()->id;
//$userbranch =  auth('api')->user()->branch;
//$userrole =  auth('api')->user()->type;
     //   if($userrole = 1)





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();

     return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
     // return   Shopbalancingrecord::latest('id')
      //  return   Branchpayout::latest('id')
        ->where('del', 0)
       ->paginate(13);

       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           










       // {
      // return Submheader::latest()
      //  -> where('ucret', $userid)
    //    ->paginate(15);
      //  }

      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];


       $this->validate($request,[
        'branchnametobalance'   => 'required | String |max:191',
        'datedone'   => 'required'
     //'amount'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
   //  $userbranch =  auth('api')->user()->branch;
   //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
   //  $hid = $id1+1;
   ///DB::table('branchtobalances')->where('ucret', $userid)->delete();
  $datepaid = date('Y-m-d');
  $inpbranch = $request['branchnametobalance'];

$dateinq =  $request['datedone'];
/// getting the expenses
$totalexpense = \DB::table('madeexpenses')
   ->where('datemade', '=', $dateinq)
   ->where('branch', '=', $inpbranch)
   
   ->where('approvalstate', '=', 1)
   ->sum('amount');

   /// getting the cashin
$totalcashin = \DB::table('couttransfers')
->where('transferdate', '=', $dateinq)
->where('branchto', '=', $inpbranch)
->where('status', '=', 1)
->sum('amount');
 /// getting the cashout
 $totalcashout = \DB::table('cintransfers')
 ->where('transferdate', '=', $dateinq)
 ->where('branchto', '=', $inpbranch)
 ->where('status', '=', 1)
 ->sum('amount');

 /// getting the payout
 $totalpayout = \DB::table('branchpayouts')
 ->where('datepaid', '=', $dateinq)
 ->where('branch', '=', $inpbranch)
// ->where('status', '=', 1)
 ->sum('amount');
///getting the openning balance
$openningbalance  = Shopbalancingrecord::where('branch', $inpbranch)->orderBy('id', 'Desc')->limit(1)->value('clcash');
//$openningbalance = \DB::table('shopbalancingrecords')
   
//->where('branch', '=', $inpbranch)
//->orderBy('id', 'Desc')
//->take(1)
//->sum('clcash');




$soccersales  = $request['scsales'];
$virtualsalesb =$request['vsales'];
$virtualpayouts = $request['vpay'];
$cancelledvirtual = $request['vcan'];

//$soccerpayout =;
//$casin =;
//$cashout =;
//$expenses =;






  $virp = ($request['vsales']-$request['vpay']-$request['vcan']);


$closingbalance = $openningbalance+$soccersales+$virtualsalesb-$virtualpayouts-$cancelledvirtual-$totalcashin+$totalcashout-$totalexpense-$totalpayout;


       return Shopbalancingrecord::Create([
      'datedone' => $request['datedone'],
      'branch' => $request['branchnametobalance'],
      'scpayout' => $totalpayout,
      'scsales' => $request['scsales'],
      'sctkts' => $request['sctkts'],
      'vsales' => $request['vsales'],
      'vcan' => $request['vcan'],
      'vprof' => $virp,
      'vpay'        => $request['vpay'],
      'vtkts'       => $request['vtkts'],
      'comment'     => $request['comment'],
      'expenses'    => $totalexpense,
      'cashin'      => $totalcashout,
      'cashout'      => $totalcashin,
      'opbalance'    => $openningbalance,
      'clcash'       => $closingbalance,
      'ucret'        => $userid,
    
  ]);
    }
///////////////////////////////////////////////////////////////////////


public function savebranchtobalance(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
        'branchnametobalance'   => 'required | String |max:191'
     //'amount'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
   //  $userbranch =  auth('api')->user()->branch;
   //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
   //  $hid = $id1+1;

  $datepaid = date('Y-m-d');
     
  //       $dats = $id;
       return Branchtobalance::Create([
      'branchnametobalance' => $request['branchnametobalance'],
     
 
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
        $user = Branchpayout::findOrfail($id);

        $this->validate($request,[
            'receiptno'   => 'required | String |max:191',
            'datemade'   => 'required',
            'branch'  => 'required',
            'amount'  => 'required'
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

        $user = Shopbalancingrecord::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
