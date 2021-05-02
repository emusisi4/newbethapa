<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Mycomponentfeature;

use App\Roleandformcomponentaction;

class AuthorisedformcomponentsController extends Controller
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

    //  if($userrole == '101')
      {
    //  return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
    $roleto  = Roleandformcomponentaction::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');
    $componentvue  = Roleandformcomponentaction::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('component');
      return   Mycomponentfeature::latest('id')
        ->where('rolein', $roleto)
      ->where('component', $componentvue)
        ->paginate(20);
      }

      
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
     //   'branchname'   => 'required | String |max:191'
       // 'iconclass'   => 'required',
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;

     $datepaid = date('Y-m-d');
  $inpbranch = $request['branchnametobalance'];

$dateinq =  $request['datedone'];
/// getting the expenses
$totalexpense = \DB::table('madeexpenses')
   ->where('datemade', '=', $dateinq)
   ->where('branch', '=', $inpbranch)
   ->where('explevel', '=', 1)
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


 /// checking if a record exists for balancing
 $branchinbalanced  = \DB::table('shopbalancingrecords')->where('branch', '=', $inpbranch) ->count();

///getting the openning balance
if($branchinbalanced > 0)
{
$openningbalance  = Shopbalancingrecord::where('branch', $inpbranch)->orderBy('id', 'Desc')->limit(1)->value('clcash');
}
if($branchinbalanced < 1)
{
$openningbalance  = Branch::where('branchno', $inpbranch)->orderBy('id', 'Desc')->limit(1)->value('openningbalance');
}
//$openningbalance = \DB::table('shopbalancingrecords')
   
//->where('branch', '=', $inpbranch)
//->orderBy('id', 'Desc')
//->take(1)
//->sum('clcash');




$soccersales  = $request['scsales'];
//$soccerpayout =;
//$casin =;
//$cashout =;
//$expenses =;






  $virp = ($request['vsales']-$request['vpay']-$request['vcan']);


$closingbalance = $openningbalance + $soccersales+ $virp + $totalcashin - $totalcashout -$totalexpense -$totalpayout;


       return Shopbalancingrecord::Create([
      'datedone' => $request['datedone'],
      'branch' => $request['branchnametobalance'],
'scpayout' => $totalpayout,
      'scsales' => $request['scsales'],
      'sctkts' => $request['sctkts'],
      'vsales' => $request['vsales'],
      'vcan' => $request['vcan'],
      'vprof' => $virp,
      'vpay' => $request['vpay'],
      'vtkts' => $request['vtkts'],
      'comment' => $request['comment'],
      'expenses' => $totalexpense,
      'cashin'    => $totalcashin,
      'cashout'   => $totalcashout,
      'opbalance'    => $openningbalance,
      'clcash'    => $closingbalance,
      'reportedcash'    => $request['reportedcash'],
      'comment'    => $request['bio'],

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

        $user = Mycomponentfeature::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
