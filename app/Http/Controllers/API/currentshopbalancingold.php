<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Dailyreportcode;
use App\Shopbalancingrecord;
use App\Salesdetail;
use App\Currentmachinecode;

class CurrentShopbalancingContoller extends Controller
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

      if($userrole == '101')
      {
      return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      // return   Shopbalancingrecord::latest('id')
       //  return   Branchpayout::latest('id')
        ->where('ucret', $userid)
        ->paginate(20);
      }


      if($userrole != '101')
      {
      
      
      return   Shopbalancingrecord::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      // return   Shopbalancingrecord::latest('id')
       //  return   Branchpayout::latest('id')
         ->where('del', 0)
        ->paginate(20);
      
    }
      
    }

   
    public function store(Request $request)
    {
      ////checking if the branch has fish
      $actonaddnew = 'fish';
      $soccer = 'soccer';
      $virtual = 'virtual';


      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
///
$inpbranch = $request['branchnametobalance'];

$doesthebranchhavefish = \DB::table('branchandproducts')->where('branch', '=', $inpbranch)->where('sysname', '=', $actonaddnew)->count();
$doesthebranchhavesoccer = \DB::table('branchandproducts')->where('branch', '=', $inpbranch)->where('sysname', '=', $soccer)->count();
$doesthebranchhavevirtual = \DB::table('branchandproducts')->where('branch', '=', $inpbranch)->where('sysname', '=', $virtual)->count();
      /// branch no fish, but has virtual and soccer
      if ($doesthebranchhavefish < 1 && $doesthebranchhavesoccer > 0 && $doesthebranchhavevirtual > 0 )
      {
        
      $this->validate($request,[
      'datedone'   => 'required  |max:191',
      'branchnametobalance'   => 'required',
      'sctkts'   => 'required',
      'vsales'   => 'required',

      'vcan'   => 'required',
      'vpay'   => 'required',
      'vtkts' => 'required',
      'reportedcash' => 'required',
      'bio' => 'required',
      'scsales'   => 'required'
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
         'fishincome' => 0,
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
       } //// closing working without fish
 /// branch with fish, has virtual and soccer
 if ($doesthebranchhavefish > 0 && $doesthebranchhavesoccer > 0 && $doesthebranchhavevirtual > 0 )
 {
      

        ///// checking for the Number of fish Machines 
        $totalfishmacinesinthebranch = \DB::table('branchesandmachines')->where('branchname', '=', $userbranch)->count();
   
  /// for one fishmachine with Soccer and virtual 
   
        if($totalfishmacinesinthebranch == 1)
     {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;

           $this->validate($request,[
       'datedone'   => 'required  |max:191',
       'branchnametobalance'   => 'required',
       'sctkts'   => 'required',
       'vsales'   => 'required',
 
       'vcan'   => 'required',
       'vpay'   => 'required',
       'vtkts' => 'required',
       'reportedcash' => 'required',
       'bio' => 'required',
       'scsales'   => 'required',
       ///////////////////////////////////// fish
      // 'machineoneopenningcode'  => 'required',
       'machineonecurrentcode'  => 'required',
       'machineonesales'  => 'required',
       'machineonepayout'  => 'required',
       'machineonefloat'  => 'required'

      ]);
      $userid =  auth('api')->user()->id;
       $datepaid = date('Y-m-d');
       $inpbranch = $request['branchnametobalance'];
       $dateinq =  $request['datedone'];
 /// getting the expenses
        $totalexpense = \DB::table('madeexpenses')->where('datemade', '=', $dateinq)->where('branch', '=', $inpbranch)->where('explevel', '=', 1)
        ->where('approvalstate', '=', 1)
        ->sum('amount');
 
    /// getting the cashin
       $totalcashin = \DB::table('couttransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)
 ->sum('amount');
  /// getting the cashout
        $totalcashout = \DB::table('cintransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)->sum('amount');
 
  /// getting the payout
        $totalpayout = \DB::table('branchpayouts')->where('datepaid', '=', $dateinq)->where('branch', '=', $inpbranch)->sum('amount');
 
 
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
 
 

 /// working on fish sales and codes
 //gitting the days code from sles and payout
$machineoneopenningcode = \DB::table('currentmachinecodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
  
$machineonecurrentcode = $request['machineonecurrentcode'];
$machineonesales = $request['machineonesales'];
$machineonepayout = $request['machineonepayout'];
$machineonefloat = $request['machineonefloat'];


 $machineoneclosingcode = $machineonecurrentcode;
 $fishincome = ($machineoneclosingcode - $machineoneopenningcode)*500;
 $closingbalance = $openningbalance + $soccersales+ $virp + $fishincome + $totalcashin - $totalcashout -$totalexpense -$totalpayout;
Shopbalancingrecord::Create([
       'fishincome' => $fishincome,
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
   //// Saving the current machinecodes
   Currentmachinecode::Create([
    'machineno' => '101',
    'datedone' => $request['datedone'],
    'branch' => $request['branchnametobalance'],
    'machinecode' => $machineoneclosingcode,
    'ucret' => $userid,
  
]);
/// working and Updating the daily Codes
Dailyreportcode::Create([
  'machineno'    => '101',
  'datedone'     => $request['datedone'],
  'branch'       => $request['branchnametobalance'],
  'closingcode'  => $machineoneclosingcode,

  'openningcode' =>    $machineoneopenningcode,
  'salescode'    =>    $machineonesales,
  'payoutcode'   =>    $machineonepayout,
  'profitcode'   =>    $machineonesales-$machineonepayout,
  'ucret' => $userid,

]);

/// working and Updating the daily Codes
/////////////////////////////////////////// checking if there is a sale or payout
$existpreviouswork = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
    ->where('machineno', '=', 101)
 //   ->where('rolein', '=', $udefinedrole)
    ->count();
//latest sales
if($existpreviouswork > 0)
{
  /// checking the reset code status
  $resetcodestatus = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
    ->where('machineno', '=', 101)
    ->where('resetstatus', '=', 1)
    ->count();
    /////
    if($resetcodestatus < 1)
    {
  $previoussalesfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('salescode');
  $previouspayoutfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('payoutcode');
    }/////
    if($resetcodestatus > 0)
      $previoussalesfigure = 0;
  $previouspayoutfigure = 0;
    }////

if($existpreviouswork < 0)
{
  $previoussalesfigure = 0;
  $previouspayoutfigure = 0;

}

Salesdetail::Create([
  'machineno'      => '101',
  'datedone'       => $request['datedone'],
  'branch'         => $request['branchnametobalance'],
  
  'previoussalesfigure' => $previoussalesfigure,
  'previouspayoutfigure' => $previouspayoutfigure,

  'currentsalesfigure'   =>    $machineonesales,
  'currentpayoutfigure'   =>   $machineonepayout,

  'salesamount'    =>    ($machineonesales - $machineonepayout)*500,
  'salesfigure'    =>    $machineonesales - $machineonepayout,


  
  
  'ucret' => $userid,

]);

        } /// closing for one machine




        } //// closing working with fish

// lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll
/// branch with fish,soccer but no Virtual 
if ($doesthebranchhavefish > 0 && $doesthebranchhavesoccer > 0 && $doesthebranchhavevirtual < 1)
{
     

       ///// checking for the Number of fish Machines 
       $totalfishmacinesinthebranch = \DB::table('branchesandmachines')->where('branchname', '=', $userbranch)->count();
  
 /// for one fishmachine with Soccer and virtual 
  
       if($totalfishmacinesinthebranch == 1)
    {
     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
     $userrole =  auth('api')->user()->type;

          $this->validate($request,[
      'datedone'   => 'required  |max:191',
      'branchnametobalance'   => 'required',
      'sctkts'   => 'required',
     // 'vsales'   => 'required',

     // 'vcan'   => 'required',
      //'vpay'   => 'required',
    //  'vtkts' => 'required',
      'reportedcash' => 'required',
      'bio' => 'required',
      'scsales'   => 'required',
      ///////////////////////////////////// fish
     // 'machineoneopenningcode'  => 'required',
      'machineonecurrentcode'  => 'required',
      'machineonesales'  => 'required',
      'machineonepayout'  => 'required',
      'machineonefloat'  => 'required'

     ]);
     $userid =  auth('api')->user()->id;
      $datepaid = date('Y-m-d');
      $inpbranch = $request['branchnametobalance'];
      $dateinq =  $request['datedone'];
/// getting the expenses
       $totalexpense = \DB::table('madeexpenses')->where('datemade', '=', $dateinq)->where('branch', '=', $inpbranch)->where('explevel', '=', 1)
       ->where('approvalstate', '=', 1)
       ->sum('amount');

   /// getting the cashin
      $totalcashin = \DB::table('couttransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)
->sum('amount');
 /// getting the cashout
       $totalcashout = \DB::table('cintransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)->sum('amount');

 /// getting the payout
       $totalpayout = \DB::table('branchpayouts')->where('datepaid', '=', $dateinq)->where('branch', '=', $inpbranch)->sum('amount');


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






 // $virp = ($request['vsales']-$request['vpay']-$request['vcan']);



/// working on fish sales and codes
//gitting the days code from sles and payout
$machineoneopenningcode = \DB::table('currentmachinecodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
 
$machineonecurrentcode = $request['machineonecurrentcode'];
$machineonesales = $request['machineonesales'];
$machineonepayout = $request['machineonepayout'];
$machineonefloat = $request['machineonefloat'];


$machineoneclosingcode = $machineonecurrentcode;
$fishincome = ($machineoneclosingcode - $machineoneopenningcode) *500;
$closingbalance = $openningbalance + $soccersales + $fishincome + $totalcashin - $totalcashout -$totalexpense -$totalpayout;
Shopbalancingrecord::Create([
      'fishincome' => $fishincome,
      'datedone' => $request['datedone'],
      'branch' => $request['branchnametobalance'],
      'scpayout' => $totalpayout,
      'scsales' => $request['scsales'],
      'sctkts' => $request['sctkts'],
      'vsales' => 0,
      'vcan' => 0,
      'vprof' => 0,
      'vpay' => 0,
      'vtkts' => 0,
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
  //// Saving the current machinecodes
  Currentmachinecode::Create([
   'machineno' => '101',
   'datedone' => $request['datedone'],
   'branch' => $request['branchnametobalance'],
   'machinecode' => $machineoneclosingcode,
   'ucret' => $userid,
 
]);
/// working and Updating the daily Codes
Dailyreportcode::Create([
 'machineno'    => '101',
 'datedone'     => $request['datedone'],
 'branch'       => $request['branchnametobalance'],
 'closingcode'  => $machineoneclosingcode,

 'openningcode' =>    $machineoneopenningcode,
 'salescode'    =>    $machineonesales,
 'payoutcode'   =>    $machineonepayout,
 'profitcode'   =>    $machineonesales-$machineonepayout,
 'ucret' => $userid,

]);

/// working and Updating the daily Codes
/////////////////////////////////////////// checking if there is a sale or payout
$existpreviouswork = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
   ->where('machineno', '=', 101)
//   ->where('rolein', '=', $udefinedrole)
   ->count();
//latest sales
if($existpreviouswork > 0)
{
 /// checking the reset code status
 $resetcodestatus = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
   ->where('machineno', '=', 101)
   ->where('resetstatus', '=', 1)
   ->count();
   /////
   if($resetcodestatus < 1)
   {
 $previoussalesfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('salescode');
 $previouspayoutfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('payoutcode');
   }/////
   if($resetcodestatus > 0)
     $previoussalesfigure = 0;
 $previouspayoutfigure = 0;
   }////

if($existpreviouswork < 0)
{
 $previoussalesfigure = 0;
 $previouspayoutfigure = 0;

}

Salesdetail::Create([
 'machineno'      => '101',
 'datedone'       => $request['datedone'],
 'branch'         => $request['branchnametobalance'],
 
 'previoussalesfigure' => $previoussalesfigure,
 'previouspayoutfigure' => $previouspayoutfigure,

 'currentsalesfigure'   =>    $machineonesales,
 'currentpayoutfigure'   =>   $machineonepayout,

 'salesamount'    =>    ($machineonesales - $machineonepayout)*500,
 'salesfigure'    =>    $machineonesales - $machineonepayout,


 
 
 'ucret' => $userid,

]);

       } /// closing for one machine




       }
      //  llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll

      
    
      if ($doesthebranchhavefish > 0 && $doesthebranchhavesoccer < 1 && $doesthebranchhavevirtual > 0 )
      {
           
     
             ///// checking for the Number of fish Machines 
             $totalfishmacinesinthebranch = \DB::table('branchesandmachines')->where('branchname', '=', $userbranch)->count();
        
       /// for one fishmachine with Soccer and virtual 
        
             if($totalfishmacinesinthebranch == 1)
          {
           $userid =  auth('api')->user()->id;
           $userbranch =  auth('api')->user()->branch;
           $userrole =  auth('api')->user()->type;
     
                $this->validate($request,[
            'datedone'   => 'required  |max:191',
            'branchnametobalance'   => 'required',
           // 'sctkts'   => 'required',
            'vsales'   => 'required',
      
            'vcan'   => 'required',
            'vpay'   => 'required',
            'vtkts' => 'required',
            'reportedcash' => 'required',
            'bio' => 'required',
           // 'scsales'   => 'required',
            ///////////////////////////////////// fish
           // 'machineoneopenningcode'  => 'required',
            'machineonecurrentcode'  => 'required',
            'machineonesales'  => 'required',
            'machineonepayout'  => 'required',
            'machineonefloat'  => 'required'
     
           ]);
           $userid =  auth('api')->user()->id;
            $datepaid = date('Y-m-d');
            $inpbranch = $request['branchnametobalance'];
            $dateinq =  $request['datedone'];
      /// getting the expenses
             $totalexpense = \DB::table('madeexpenses')->where('datemade', '=', $dateinq)->where('branch', '=', $inpbranch)->where('explevel', '=', 1)
             ->where('approvalstate', '=', 1)
             ->sum('amount');
      
         /// getting the cashin
            $totalcashin = \DB::table('couttransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)
      ->sum('amount');
       /// getting the cashout
             $totalcashout = \DB::table('cintransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)->sum('amount');
      
       /// getting the payout
             $totalpayout = \DB::table('branchpayouts')->where('datepaid', '=', $dateinq)->where('branch', '=', $inpbranch)->sum('amount');
      
      
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
      
      
      
      
     // $soccersales  = $request['scsales'];
      //$soccerpayout =;
      //$casin =;
      //$cashout =;
      //$expenses =;
      
      
      
      
      
      
        $virp = ($request['vsales']-$request['vpay']-$request['vcan']);
      
      
     
      /// working on fish sales and codes
      //gitting the days code from sles and payout
     $machineoneopenningcode = \DB::table('currentmachinecodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
       
     $machineonecurrentcode = $request['machineonecurrentcode'];
     $machineonesales = $request['machineonesales'];
     $machineonepayout = $request['machineonepayout'];
     $machineonefloat = $request['machineonefloat'];
     
     
      $machineoneclosingcode = $machineonecurrentcode;
      $fishincome = ($machineoneclosingcode - $machineoneopenningcode)*500;
      $closingbalance = $openningbalance + $soccersales+ $virp + $fishincome + $totalcashin - $totalcashout -$totalexpense -$totalpayout;
     Shopbalancingrecord::Create([
            'fishincome' => $fishincome,
            'datedone' => $request['datedone'],
            'branch' => $request['branchnametobalance'],
            'scpayout' => $totalpayout,
            'scsales' =>0,
            'sctkts' => 0,
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
        //// Saving the current machinecodes
        Currentmachinecode::Create([
         'machineno' => '101',
         'datedone' => $request['datedone'],
         'branch' => $request['branchnametobalance'],
         'machinecode' => $machineoneclosingcode,
         'ucret' => $userid,
       
     ]);
     /// working and Updating the daily Codes
     Dailyreportcode::Create([
       'machineno'    => '101',
       'datedone'     => $request['datedone'],
       'branch'       => $request['branchnametobalance'],
       'closingcode'  => $machineoneclosingcode,
     
       'openningcode' =>    $machineoneopenningcode,
       'salescode'    =>    $machineonesales,
       'payoutcode'   =>    $machineonepayout,
       'profitcode'   =>    $machineonesales-$machineonepayout,
       'ucret' => $userid,
     
     ]);
     
     /// working and Updating the daily Codes
     /////////////////////////////////////////// checking if there is a sale or payout
     $existpreviouswork = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
         ->where('machineno', '=', 101)
      //   ->where('rolein', '=', $udefinedrole)
         ->count();
     //latest sales
     if($existpreviouswork > 0)
     {
       /// checking the reset code status
       $resetcodestatus = \DB::table('dailyreportcodes')->where('branch', '=', $userbranch)
         ->where('machineno', '=', 101)
         ->where('resetstatus', '=', 1)
         ->count();
         /////
         if($resetcodestatus < 1)
         {
       $previoussalesfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('salescode');
       $previouspayoutfigure = \DB::table('dailyreportcodes')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('payoutcode');
         }/////
         if($resetcodestatus > 0)
           $previoussalesfigure = 0;
       $previouspayoutfigure = 0;
         }////
     
     if($existpreviouswork < 0)
     {
       $previoussalesfigure = 0;
       $previouspayoutfigure = 0;
     
     }
     
     Salesdetail::Create([
       'machineno'      => '101',
       'datedone'       => $request['datedone'],
       'branch'         => $request['branchnametobalance'],
       
       'previoussalesfigure' => $previoussalesfigure,
       'previouspayoutfigure' => $previouspayoutfigure,
     
       'currentsalesfigure'   =>    $machineonesales,
       'currentpayoutfigure'   =>   $machineonepayout,
     
       'salesamount'    =>    ($machineonesales - $machineonepayout)*500,
       'salesfigure'    =>    $machineonesales - $machineonepayout,
     
     
       
       
       'ucret' => $userid,
     
     ]);
     
             } /// closing for one machine
     
     
     
     
             } //// closing working with fish

            //  lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll
            if ($doesthebranchhavefish > 0 && $doesthebranchhavesoccer < 1 && $doesthebranchhavevirtual < 1 )
            {
                 
           
                   ///// checking for the Number of fish Machines 
                   $totalfishmacinesinthebranch = \DB::table('branchesandmachines')->where('branchname', '=', $userbranch)->count();
              
             /// for one fishmachine with Soccer and virtual 
              
                   if($totalfishmacinesinthebranch == 1)
                {
                 $userid =  auth('api')->user()->id;
                 $userbranch =  auth('api')->user()->branch;
                 $userrole =  auth('api')->user()->type;
           
                      $this->validate($request,[
                  'datedone'   => 'required  |max:191',
                  'branchnametobalance'   => 'required',
                  'reportedcash' => 'required',
                  'bio' => 'required',
                
                  ///////////////////////////////////// fish
               
                  'machineonecurrentcode'  => 'required',
                  'machineonesales'  => 'required',
                  'machineonepayout'  => 'required',
                  'machineonefloat'  => 'required'
           
                 ]);
                 $userid =  auth('api')->user()->id;
                  $datepaid = date('Y-m-d');
                  $inpbranch = $request['branchnametobalance'];
                  $dateinq =  $request['datedone'];




/// checking for Machine resets status 
  $machineresetstatus = \DB::table('machineresets')->where('branch', $inpbranch)->where('machine', '101')->orderBy('id', 'Desc')->limit(1)->value('resetdate');
  
  
if( $machineresetstatus  != $dateinq)
{



            /// getting the expenses
                   $totalexpense = \DB::table('madeexpenses')->where('datemade', '=', $dateinq)->where('branch', '=', $inpbranch)->where('explevel', '=', 1)
                   ->where('approvalstate', '=', 1)
                   ->sum('amount');
            
               /// getting the cashin
                  $totalcashin = \DB::table('couttransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)
            ->sum('amount');
             /// getting the cashout
                   $totalcashout = \DB::table('cintransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)->sum('amount');
            
             /// getting the payout
                   $totalpayout = \DB::table('branchpayouts')->where('datepaid', '=', $dateinq)->where('branch', '=', $inpbranch)->sum('amount');
            
            
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
          
            /// working on fish sales and codes
            //gitting the days code from sles and payout

            $dateinact = $request['datedone'];
            $yearmade = date('Y', strtotime($dateinact));
            $monthmade = date('m', strtotime($dateinact));

           $machineoneopenningcode = \DB::table('currentmachinecodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
             







           $machineonecurrentcode = $request['machineonecurrentcode'];
           $machineonesales = $request['machineonesales'];
           $machineonepayout = $request['machineonepayout'];
           $machineonefloat = $request['machineonefloat'];
           
           
            $machineoneclosingcode = $machineonecurrentcode;
            $fishincome = ($machineoneclosingcode - $machineoneopenningcode)*500;
            $closingbalance = $openningbalance + $fishincome + $totalcashin - $totalcashout -$totalexpense -$totalpayout;
           Shopbalancingrecord::Create([
                  'fishincome' => $fishincome,
                  'fishsales' => $machineonesales,
                  'fishpayout' => $machineonepayout,
                  'datedone' => $request['datedone'],
                  'branch' => $request['branchnametobalance'],
                  'scpayout' => 0,
                  'scsales' =>0,
                  'sctkts' => 0,
                  'vsales' => 0,
                  'vcan' => 0,
                  'vprof' => 0,
                  'vpay' => 0,
                  'vtkts' => 0,
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
              //// Saving the current machinecodes
              Currentmachinecode::Create([
               'machineno' => '101',
               'datedone' => $request['datedone'],
               'branch' => $request['branchnametobalance'],
               'machinecode' => $machineoneclosingcode,
               'ucret' => $userid,
             
           ]);
           //ooooooooooooooooooooooooooooooooooooooooooooooooooooooo
 /// working and Updating the daily Codes
           /////////////////////////////////////////// checking if there is a sale or payout
           $existpreviouswork = \DB::table('dailyreportcodes')->where('branch', '=', $inpbranch)->where('machineno', '=', 101)->count();
          //  //latest sales
          
          //    $resetcodestatus = \DB::table('dailyreportcodes')->where('branch', '=', $inpbranch)
          //      ->where('machineno', '=', 101)
          //      ->where('resetstatus', '=', 1)
          //      ->count();
              if($existpreviouswork > 0)
              {
             $previoussalesfigure = \DB::table('dailyreportcodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('salescode');
             $previouspayoutfigure = \DB::table('dailyreportcodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('payoutcode');
              }
              if($existpreviouswork < 1)
              {
                $previoussalesfigure = 0;
                $previouspayoutfigure = 0;
              }
          //      if($resetcodestatus > 0)
          //        $previoussalesfigure = 0;
          //    $previouspayoutfigure = 0;
        
           
          //  if($existpreviouswork < 1)
          //  {
          //    $previoussalesfigure = 0;
          //    $previouspayoutfigure = 0;
           
          //  }
           //00000000000000000000000000000000000000000000000000000000000000000


/// calculating the current or dayz sales and payout
$todayssaes1 = $machineonesales - $previoussalesfigure;
$todayspayout11 = $machineonepayout - $previouspayoutfigure;
if($todayssaes1 >= 0)
{
  $todayssaes = $todayssaes1;
}
if($todayssaes1 < 0)
{
  $todayssaes = $machineonesales;
}
//
if($todayspayout11 >= 0)
{
  $todayspayout = $todayspayout11;
}
if($todayspayout11 < 0)
{
  $todayspayout = $machineonepayout;
}
///// getting the branch order
$dorder = \DB::table('branches')->where('id', '=', $userbranch)->count('dorder');
/// deleting the existing record
$bxn = $request['branchnametobalance'];
$datedonessd = $request['datedone'];
DB::table('dailyreportcodes')->where('branch', $bxn)->where('datedone', $datedonessd)->where('machineno', 101)->delete();


           /// working and Updating the daily Codes
           Dailyreportcode::Create([
             'machineno'    => '101',
             'datedone'     => $request['datedone'],
             'branch'       => $request['branchnametobalance'],
             'closingcode'  => $machineoneclosingcode,
           
             'openningcode' =>    $machineoneopenningcode,
             'salescode'    =>    $machineonesales,
             'payoutcode'   =>    $machineonepayout,
             'profitcode'   =>    $machineonesales-$machineonepayout,
             'previoussalesfigure'  =>    $previoussalesfigure,
             'previouspayoutfigure' =>    $previouspayoutfigure,
             'currentpayoutfigure'  =>    $todayspayout,
             'currentsalesfigure'   =>    $todayssaes,
             'dorder'  =>    $dorder,
             'ucret'   => $userid,
             'monthmade'    => $monthmade,
             'yearmade'     => $yearmade,
           
           ]);
           
          
           
           Salesdetail::Create([
             'machineno'      => '101',
             'datedone'       => $request['datedone'],
             'branch'         => $request['branchnametobalance'],
             
             'previoussalesfigure' => $previoussalesfigure,
             'previouspayoutfigure' => $previouspayoutfigure,
           
             'currentsalesfigure'   =>    $machineonesales,
             'currentpayoutfigure'   =>   $machineonepayout,
           
             'salesamount'    =>    ($machineonesales - $machineonepayout)*500,
             'salesfigure'    =>    $machineonesales - $machineonepayout,
           
             'monthmade'    => $monthmade,
             'yearmade'    => $yearmade,
             
             
             'ucret' => $userid,
           
           ]);
           
          } /// COSING IF THE MACHINE WAS NOT RESET

           
if( $machineresetstatus  == $dateinq)
{



            /// getting the expenses
                   $totalexpense = \DB::table('madeexpenses')->where('datemade', '=', $dateinq)->where('branch', '=', $inpbranch)->where('explevel', '=', 1)
                   ->where('approvalstate', '=', 1)
                   ->sum('amount');
            
               /// getting the cashin
                  $totalcashin = \DB::table('couttransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)
            ->sum('amount');
             /// getting the cashout
                   $totalcashout = \DB::table('cintransfers')->where('transferdate', '=', $dateinq)->where('branchto', '=', $inpbranch)->where('status', '=', 1)->sum('amount');
            
             /// getting the payout
                   $totalpayout = \DB::table('branchpayouts')->where('datepaid', '=', $dateinq)->where('branch', '=', $inpbranch)->sum('amount');
            
            
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
          
            /// working on fish sales and codes
            //gitting the days code from sles and payout

            $dateinact = $request['datedone'];
            $yearmade = date('Y', strtotime($dateinact));
            $monthmade = date('m', strtotime($dateinact));

           $machineoneopenningcode = \DB::table('currentmachinecodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
             







           $machineonecurrentcode = $request['machineonecurrentcode'];
           $machineonesales = $request['machineonesales'];
           $machineonepayout = $request['machineonepayout'];
           $machineonefloat = $request['machineonefloat'];
           
           
            $machineoneclosingcode = $machineonecurrentcode;
            $fishincome = ($machineoneclosingcode)*500;
            $closingbalance = $openningbalance + $fishincome + $totalcashin - $totalcashout -$totalexpense -$totalpayout;
           Shopbalancingrecord::Create([
                  'fishincome' => $fishincome,
                  'fishsales' => $machineonesales,
                  'fishpayout' => $machineonepayout,
                  'datedone' => $request['datedone'],
                  'branch' => $request['branchnametobalance'],
                  'scpayout' => 0,
                  'scsales' =>0,
                  'sctkts' => 0,
                  'vsales' => 0,
                  'vcan' => 0,
                  'vprof' => 0,
                  'vpay' => 0,
                  'vtkts' => 0,
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
              //// Saving the current machinecodes
              Currentmachinecode::Create([
               'machineno' => '101',
               'datedone' => $request['datedone'],
               'branch' => $request['branchnametobalance'],
               'machinecode' => $machineoneclosingcode,
               'ucret' => $userid,
             
           ]);
           //ooooooooooooooooooooooooooooooooooooooooooooooooooooooo
 /// working and Updating the daily Codes
           /////////////////////////////////////////// checking if there is a sale or payout
           $existpreviouswork = \DB::table('dailyreportcodes')->where('branch', '=', $inpbranch)->where('machineno', '=', 101)->count();
          //  //latest sales
          
          //    $resetcodestatus = \DB::table('dailyreportcodes')->where('branch', '=', $inpbranch)
          //      ->where('machineno', '=', 101)
          //      ->where('resetstatus', '=', 1)
          //      ->count();
              if($existpreviouswork > 0)
              {
             $previoussalesfigure = \DB::table('dailyreportcodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('salescode');
             $previouspayoutfigure = \DB::table('dailyreportcodes')->where('branch', $inpbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('payoutcode');
              }
              if($existpreviouswork < 1)
              {
                $previoussalesfigure = 0;
                $previouspayoutfigure = 0;
              }
          //      if($resetcodestatus > 0)
          //        $previoussalesfigure = 0;
          //    $previouspayoutfigure = 0;
        
           
          //  if($existpreviouswork < 1)
          //  {
          //    $previoussalesfigure = 0;
          //    $previouspayoutfigure = 0;
           
          //  }
           //00000000000000000000000000000000000000000000000000000000000000000


/// calculating the current or dayz sales and payout
$todayssaes1 = $machineonesales - $previoussalesfigure;
$todayspayout11 = $machineonepayout - $previouspayoutfigure;
if($todayssaes1 >= 0)
{
  $todayssaes = $todayssaes1;
}
if($todayssaes1 < 0)
{
  $todayssaes = $machineonesales;
}
//
if($todayspayout11 >= 0)
{
  $todayspayout = $todayspayout11;
}
if($todayspayout11 < 0)
{
  $todayspayout = $machineonepayout;
}
///// getting the branch order
$dorder = \DB::table('branches')->where('id', '=', $userbranch)->count('dorder');
/// deleting the existing record
$bxn = $request['branchnametobalance'];
$datedonessd = $request['datedone'];
DB::table('dailyreportcodes')->where('branch', $bxn)->where('datedone', $datedonessd)->where('machineno', 101)->delete();


           /// working and Updating the daily Codes
           Dailyreportcode::Create([
             'machineno'    => '101',
             'datedone'     => $request['datedone'],
             'branch'       => $request['branchnametobalance'],
             'closingcode'  => $machineoneclosingcode,
           
             'openningcode' =>    $machineoneopenningcode,
             'salescode'    =>    $machineonesales,
             'payoutcode'   =>    $machineonepayout,
             'profitcode'   =>    $machineonesales-$machineonepayout,
             'previoussalesfigure'  =>    $previoussalesfigure,
             'previouspayoutfigure' =>    $previouspayoutfigure,
             'currentpayoutfigure'  =>    $todayspayout,
             'currentsalesfigure'   =>    $todayssaes,
             'dorder'  =>    $dorder,
             'ucret'   => $userid,
             'monthmade'    => $monthmade,
             'yearmade'     => $yearmade,
           
           ]);
           
          
           
           Salesdetail::Create([
             'machineno'      => '101',
             'datedone'       => $request['datedone'],
             'branch'         => $request['branchnametobalance'],
             
             'previoussalesfigure' => $previoussalesfigure,
             'previouspayoutfigure' => $previouspayoutfigure,
           
             'currentsalesfigure'   =>    $machineonesales,
             'currentpayoutfigure'   =>   $machineonepayout,
           
             'salesamount'    =>    ($machineonesales - $machineonepayout)*500,
             'salesfigure'    =>    $machineonesales - $machineonepayout,
           
             'monthmade'    => $monthmade,
             'yearmade'    => $yearmade,
             
             
             'ucret' => $userid,
           
           ]);
           
          } /// COSING IF THE MACHINE WAS  RESET TO ZERO

          
                   } /// closing for one machine
           
          //  llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll
           
           
                   } //// closing working with fish
    
    
    
                 
    
    
    
    
    
    
    
    
    
    
    
    
    
    }//// Genrral store close




      
 
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

  
    
    public function destroy($id)
    {
        //
     //   $this->authorize('isAdmin'); 
     $bxn = \DB::table('shopbalancingrecords')->where('id', '=', $id)->value('branch');
     $datedonessd = \DB::table('shopbalancingrecords')->where('id', '=', $id)->value('datedone');

        $user = Shopbalancingrecord::findOrFail($id);
        $user->delete();

        // $bxn = \DB::table('shopbalancingrecords')->where('id', '=', $id)->value('branch');
        // $datedonessd = \DB::table('shopbalancingrecords')->where('id', '=', $id)->value('datedone');
       
       
//         /// deleting from the daily record
//     
DB::table('dailyreportcodes')->where('branch', $bxn)->where('datedone', $datedonessd)->delete();
DB::table('currentmachinecodes')->where('branch', $bxn)->where('datedone', $datedonessd)->delete();


    }
}
