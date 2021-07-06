<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branchandproduct;
use App\Daysummarry;
use App\Branchesandmachine;
use App\Branchinaction;
use App\Dailyreportcode;
class AutocorrectsalesdetailsController extends Controller
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

    //  if($userrole == '101')
      {
    //  return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
    $roleto  = Branchinaction::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branch');
    return    Branchesandmachine::with(['branchnameBranchmachines','machinenameBranchmachines'])->latest('id')
  // return   Branchesandmachine::latest('id')
        //  ->where('branch', $roleto)
        ->paginate(30);
      }

      
    }

 
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
       'datedone'   => 'required',
       'branchname'   => 'required'
     //  'product'   => 'required'
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;

  $datepaid = date('Y-m-d');
///// working the dailysummary
$dateinact = $request['datedone'];
$yearmade = date('Y', strtotime($dateinact));
$monthmade = date('m', strtotime($dateinact));
$datedonessd = $request['datedone'];

$inpbranch = $request['branchname'];

////////////////////////////////////////////////////////////////////////////////////////////////////
  $bethapavirtualsales = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('vsales');
  $bethapasoccersales= \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('scsales');
 $bethapavirtualpayout = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('vpay');
 $bethapaonlinewithdraws = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('onlinewithdraws');
 $bethapaonlinedeposits = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('onlinedeposits');
 $bethapasoccerpayout = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('scpayout');
 $bethapavirtualcancelled= \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('vcan');
//
$totalcashout = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('cashout');
$totalcashin = \DB::table('shopbalancingrecords')->where('datedone', '=', $dateinact)->where('branch', '=', $inpbranch)->sum('cashin');

 DB::table('dailyreportcodes')->where('branch', $inpbranch)->where('datedone', $dateinact)->delete();
Dailyreportcode::Create([
 // 'machineno'    => '101',
  'datedone'     => $request['datedone'],
  'branch'       => $inpbranch,
 // 'closingcode'  => $machineoneclosingcode,
//  'floatcode'    => $request['machineonefloat'],
//  'openningcode' =>    $machineoneopenningcode,
//  'salescode'    =>    $machineonesales,
//  'payoutcode'   =>    $machineonepayout,
//  'profitcode'   =>    $machineonesales-$machineonepayout,
//  'previoussalesfigure'  =>    $previoussalesfigure,
//  'previouspayoutfigure' =>    $previouspayoutfigure,
//  'currentpayoutfigure'  =>    $todayspayout,
//  'currentsalesfigure'   =>    $todayssaes,
 // 'dorder'  =>    $dorder,
  'ucret'   => $userid,
  'totalcollection' => $totalcashout,
  'totalcredits'=> $totalcashin,
  'bethapavirtualpayout' =>$bethapavirtualpayout,
  'bethapavirtualcancelled' => $bethapavirtualcancelled,
  'bethapavirtualsales' => $bethapavirtualsales,
  'bethapaonlinewithdraws' => $bethapaonlinewithdraws,
  'bethapaonlinedeposits' => $bethapaonlinedeposits,
  'bethapasoccerpayout' => $bethapasoccerpayout,
  'bethapasoccersales' => $bethapasoccersales,
 


//  'daysalesamount' => $todayssaes*500,
//  'daypayoutamount' => $todayspayout*500,
  'monthmade'    => $monthmade,
  'yearmade'     => $yearmade,

]);

//////////////////////////////////////////////////////////////////////////////
// sales summary
//id, datedone, salesamount, payoutamount, ucret, created_at, updated_at, 
//yeardone, monthdone, soccersales, soccerpayout, soccerprofit, virtualsales, virtualcancelled, virtualpayout, onlinedeposits, onlinewithdraws
$newsalesasummaryfortheday = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('daysalesamount'); /// fishsales

$newpayoutsummaryfortheday = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('daypayoutamount'); // fishpayout

//// soccer sales
$newdailysoccersales = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapasoccersales'); // soccer sales
//
/// soccer sales
$newdailysoccerpayout = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapasoccerpayout'); // soccer payout
/// online deposits
$newdailyonlinedeposits = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapaonlinedeposits'); // online deposits
/// online withdraws
$newdailyonlinewithdraws = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapaonlinewithdraws'); // online withdraws
/// online virtual sales
$newdailyvirtualsales = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapavirtualsales'); // virtual sales
/// online virtual sales
$newdailyvirtualpayout = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapavirtualpayout'); // virtual payout

/// virtual cancelled
$newdailyvirtualcancelled = \DB::table('dailyreportcodes')
->where('datedone', '=', $datedonessd)
->sum('bethapavirtualcancelled'); // virtual cancelled

//id, datedone, salesamount, payoutamount, ucret, created_at, updated_at, yeardone, monthdone,
// soccersales, soccerpayout, soccerprofit, virtualsales, virtualcancelled, virtualpayout, onlinedeposits, onlinewithdraws

DB::table('daysummarries')->where('datedone', $datedonessd)->delete();
    
Daysummarry::Create([
  // 'salesamount'    => $newsalesasummaryfortheday,
  // 'datedone'       => $datedonessd,
  // 'payoutamount'   => $newpayoutsummaryfortheday,
  'onlinewithdraws'    => $newdailyonlinewithdraws,
  'datedone'       => $datedonessd,
  'onlinedeposits'   => $newdailyonlinedeposits,
  'virtualpayout'    => $newdailyvirtualpayout,
  'virtualcancelled' => $newdailyvirtualcancelled,
  'virtualsales'   => $newdailyvirtualcancelled,
  'soccerprofit' => $newdailysoccersales-$newdailysoccerpayout,
  'soccerpayout'   => $newdailysoccerpayout,
  'soccersales'   => $newdailysoccersales,

  'yeardone'       => $monthmade,
  'monthdone'      => $yearmade,
    
  'ucret' => $userid,

]);


    }
////////////////////////////////////////////////////////////////////
    public function show($id)
    {
        //
    }
  
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

        $user = Shopbalancingrecord::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
