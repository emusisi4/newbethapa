<?php

  

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
  

use Illuminate\Http\Request;
use App\Machine;
use App\Country;
use App\Branchandproduct;
use App\Bettingproduct;
use App\State;
use App\Branch;
use App\Role;
use App\Usertype; 
use App\Roletoaddcomponent;
use App\Thecomponent;
use App\Formcomponent;
use App\Submheader;
use App\Mainmenu;
use App\Mainmenucomponent;
use App\Expense;
use App\Branchtobalance;
use App\Shopbalancingrecord;
use App\Branchtocollect;
use App\Bopenningbalance;
use App\Expensetype;
use App\Expensescategory;
use App\User;
use App\Currentmachinecode;
use App\Branchanduser;
class APIController extends Controller

{


    public function getCountries()

    { $data = Country::get(); return response()->json($data); }

    public function getRoles()

    { 
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
     

      $data = Role::get(); 
      if($userrole !=   '900'){
         return response()->json($data);
      }
     
     }

     
public function Bopenningbalance()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];


   // $closingcash = \DB::table('shopbalancingrecords')
   
   // ->where('branch', '=', $branchto)
   // ->orderByDesc('id')
   // ->limit(1)
   // ->get('clcash');

    $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
    $closingcash  = Shopbalancingrecord::where('branch', $branchto)->orderBy('id', 'Desc')->limit(1)->value('clcash');

    return $closingcash;
}



}
public function Branchtobalancedayscashout()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   $totalcashout = \DB::table('cintransfers')
   
    ->where('branchto', '=', $branchto)
    ->where('transferdate', '=', $dateinquestion)
    ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalcashout;
}

}

public function Branchtobalancedayexpenses()
{
   

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   $totalexpenses = \DB::table('madeexpenses')
   
    ->where('branch', '=', $branchto)
    ->where('datemade', '=', $dateinquestion)
    ->where('approvalstate', '=', 1)
    ->where('explevel', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalexpenses;
}

}
public function Branchtobalancedaypayout()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   $totalpayout = \DB::table('branchpayouts')
   
    ->where('branch', '=', $branchto)
    ->where('datepaid', '=', $dateinquestion)
   // ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalpayout;
}

}


public function Branchtobalancedayscashin()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   $totalcashin = \DB::table('couttransfers')
   
    ->where('branchto', '=', $branchto)
    ->where('transferdate', '=', $dateinquestion)
    ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalcashin;
}

}

public function Bopenningbalancetoday()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];


   // $closingcash = \DB::table('shopbalancingrecords')
   
   // ->where('branch', '=', $branchto)
   // ->orderByDesc('id')
   // ->limit(1)
   // ->get('clcash');

    $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
    $closingcash  = Shopbalancingrecord::where('branch', $branchto)->orderBy('id', 'Desc')->limit(1)->value('clcash');

    return $closingcash;
}



}

     public function getIfthebranchisalreadybalanced()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;

//////////// geting the shop to balance
$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
 $branchtobalanceexisits = \DB::table('shopbalancingrecords')

    ->where('branch', '=', $branchto)
    ->where('datedone', '=', $dateinquestion)
    ->count();

    return $branchtobalanceexisits;
   
}

public function mybranch()
     {
         $userid =  auth('api')->user()->id;
         $userbranch =  auth('api')->user()->branch;
         $userrole =  auth('api')->user()->type;
        /// $roleto  = Bran::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');  
      
        if($userrole == '101')
        {
        $data = Branchanduser::latest('id')
        ->where('username', '=', $userid)
        ->get();
        
                return response()->json($data);
        }
        if($userrole != '101')
        {
        $data = Branch::latest('id')
       // ->where('id', '=', $userbranch)
        ->get();
                return response()->json($data);
        }
   }
   
   public function branchmachineslist()
   {
       $userid =  auth('api')->user()->id;
       $userbranch =  auth('api')->user()->branch;
       $userrole =  auth('api')->user()->type;
      /// $roleto  = Bran::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');  
     
      $data = Machine::orderby('id', 'Asc')
      //->where('sysname', '!=', $component)
      ->get();
              return response()->json($data);
 }

   public function bettingproducts()
   {
       $userid =  auth('api')->user()->id;
       $userbranch =  auth('api')->user()->branch;
       $userrole =  auth('api')->user()->type;
      /// $roleto  = Bran::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');  
     
      $data = Bettingproduct::latest('id')
      //->where('sysname', '!=', $component)
      ->get();
              return response()->json($data);
 }




     public function branchDetails()
     {
         $userid =  auth('api')->user()->id;
         $userbranch =  auth('api')->user()->branch;
         $userrole =  auth('api')->user()->type;
        /// $roleto  = Bran::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');  
       
        $data = Branch::latest('id')
        //->where('sysname', '!=', $component)
        ->get();
                return response()->json($data);
   }
    public function getcomponentslist()
    {
        $userid =  auth('api')->user()->id;
        $userbranch =  auth('api')->user()->branch;
        $userrole =  auth('api')->user()->type;
        $roleto  = Roletoaddcomponent::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('rolename');  
      
$data = Thecomponent::latest('id')
//->where('sysname', '!=', $component)
->get();
        return response()->json($data);
    




    }

    public function getSubmenues()
    {
     
$data = Submheader::latest('id')
->where('del', 0)
->get();
        return response()->json($data);
    }
    public function getMainmenues()
    {
     
$data = Mainmenucomponent::latest('id')
->where('del', 0)
->get();
        return response()->json($data);
    }

    public function getformfeatures()
    {
        $userid =  auth('api')->user()->id;
        $userbranch =  auth('api')->user()->branch;
        $userrole =  auth('api')->user()->type;

   
$data = Formcomponent::latest('id')
//->where('branchno', $userbranch)
->get();
        return response()->json($data);
  
    }
    
    public function userslist()

    {
      $data = User::get();
       return response()->json($data); 
      }

   
      public function getUsertypes()

      {
        $data = Usertype::get();
         return response()->json($data); 
        }


    
    public function getStates(Request $request)

    { $data = State::where('country_id', $request->country_id)->get(); return response()->json($data); }

///////////////////////////////////////////////////////////




public function todayscashintotal()
{
/// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;

     
  $currentdate = date('Y-m-d');
  if($userrole == '101')
  {    
  $totalbranchopenning = \DB::table('couttransfers')
   
   ->where('branchto', '=', $userbranch)
   ->where('transferdate', '=', $currentdate)
   ->where('status', '=', 1)
   ->sum('amount');
    return $totalbranchopenning;
  }
  if($userrole != '101')
  {    
  $totalbranchopenning = \DB::table('couttransfers')
   
  // ->where('branchto', '=', $userbranch)
   ->where('transferdate', '=', $currentdate)
   ->where('status', '=', 1)
   ->sum('amount');
    return $totalbranchopenning;
  }

}
public function todayscashouttotal()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

  
   //  $openningbalance  = Branchcasstanding::latest('id')->where('branch', $userbranch)->value('outstanding');
    // $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  
     
    $currentdate = date('Y-m-d');
   $totalbranchopenning = \DB::table('cintransfers')
   
    ->where('branchto', '=', $userbranch)
    ->where('transferdate', '=', $currentdate)
    ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalbranchopenning;
}


}
public function todaysexpensestotal()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

  
   //  $openningbalance  = Branchcasstanding::latest('id')->where('branch', $userbranch)->value('outstanding');
    // $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  
     
    $currentdate = date('Y-m-d');
   $totalbranchopenning = \DB::table('madeexpenses')
   
    ->where('branch', '=', $userbranch)
    ->where('datemade', '=', $currentdate)
    ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalbranchopenning;
}

}




public function todayspayouttotal()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

  
   //  $openningbalance  = Branchcasstanding::latest('id')->where('branch', $userbranch)->value('outstanding');
    // $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  
     
    $currentdate = date('Y-m-d');
   $totaldayspayout = \DB::table('branchpayouts')
   
    ->where('bpaying', '=', $userbranch)
    ->where('datepaid', '=', $currentdate)
   // ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totaldayspayout;
}

}

























/////////////////////////////////////////////////////////////////
public function shopopenningpalance()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

  
   //  $openningbalance  = Branchcasstanding::latest('id')->where('branch', $userbranch)->value('outstanding');
    // $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  
     
    $currentdate = date('Y-m-d');
   $totalbranchopenning = \DB::table('branchcashstandings')
   
    ->where('branch', '=', $userbranch)
   // ->where('datepaid', '=', $currentdate)
   // ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('outstanding');
    return $totalbranchopenning;
}

}
///////////////////////////////////////////////////////////////////////////////


public function mainmenuaccessComponent()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

$comp ='mainmenucomponentsvue';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
























public function generalcomponentaccessComponentfeatures()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='formcomponentsmanagement';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
/////////////// Expenses catiomdmmd
public function componentaccessExpensecategories()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='expensecategorycomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

public function componentaccessExpensetype()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='expensetypecomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}



////////////////////////// f
































///////////////////////////////////////////////////////////////



public function gencomponentaccessExpenses()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='generalexpensescomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

public function gencomponentaccessCahtransactions()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='gencashtransactionsComp';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

public function gencomponentaccessHrms()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='gencomponentaccessHrms';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function generalcomponentaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='generalcomponentaccessSettings';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
///////----------------------------------------------------------------///////////////////

public function getAddnewpayout()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "payoutcomponent-branch";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}

public function getauthorisedtransferlist()
{
 
$data = User::latest('id')
->where('haswalet', 1)
//->where('id','!=', $userid)
->get();
    return response()->json($data);
}
public function getExpensestomake()
{
 
$data = Expense::latest('id')
->where('del', 0)
->get();
    return response()->json($data);
}

















/// brands
public function getcompaniesd()
{
$userid =  auth('api')->user()->id;
$userbranch =  auth('api')->user()->branch;
$userrole =  auth('api')->user()->type;
//  if($userrole == 101)
{
$data = Company::latest('id')
//->where('branchno', $userbranch)
->get();
return response()->json($data);
}

}
////
//////////////////

public function allowedtomakecashtransfer()
    {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
      $udefinedrole =  auth('api')->user()->mmaderole;

    //$data = DB::table('users')->count();
    $component = "makecashtransfercomponent";
    $actonaddnew = 'addnew';

    $wordCount = \DB::table('mycomponentfeatures')
      ->where('component', '=', $component)
        ->where('formcomponent', '=', $actonaddnew)
        ->where('rolein', '=', $udefinedrole)
        ->count();

        return $wordCount;
        
      
    }
    














/////////////////////
public function getaddnewofficeexpense()
    {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
      $udefinedrole =  auth('api')->user()->mmaderole;

    //$data = DB::table('users')->count();
    $component = "makeexpenseofficecomponent";
    $actonaddnew = 'addnew';

    $wordCount = \DB::table('mycomponentfeatures')
      ->where('component', '=', $component)
        ->where('formcomponent', '=', $actonaddnew)
        ->where('rolein', '=', $udefinedrole)
        ->count();

        return $wordCount;
        
      
    }
    public function getAddnewexpenserecord()
    {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
      $udefinedrole =  auth('api')->user()->mmaderole;

    //$data = DB::table('users')->count();
    $component = "branchexpenserecords-branch";
    $actonaddnew = 'addnew';

    $wordCount = \DB::table('mycomponentfeatures')
      ->where('component', '=', $component)
        ->where('formcomponent', '=', $actonaddnew)
        ->where('rolein', '=', $udefinedrole)
        ->count();

        return $wordCount;
        
      
    }


    public function geteditofficeexpense()
    {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
      $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "makeexpenseofficecomponent";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}

    public function editbranchpayout()
    {
      $userid =  auth('api')->user()->id;
      $userbranch =  auth('api')->user()->branch;
      $userrole =  auth('api')->user()->type;
      $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "payoutcomponent-branch";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}

public function getdeleteofficeexpense()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "makeexpenseofficecomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function deletebranchpayout()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "payoutcomponent-branch";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function Branchtodayscashin()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
    /// $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
    $currentdate = date('Y-m-d');
   $totalcashin = \DB::table('couttransfers')
   
    ->where('branchto', '=', $branchto)
    ->where('transferdate', '=', $currentdate)
    ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalcashin;
}

}

public function Branchtodayspayout()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

  
     $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
    // $dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  
     
    $currentdate = date('Y-m-d');
   $totalpayout = \DB::table('branchpayouts')
   
    ->where('branch', '=', $branchto)
    ->where('datepaid', '=', $currentdate)
   // ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalpayout;
}

}

public function Branchnametocollectfrom()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   // $bnames = \DB::table('branches')
   
  //  ->where('branchno', '=', $bnames)
    //->orderByDesc('id')
    //->limit(1)
  //  ->sum('clcash');
    return $bnames;
}



}

public function Branchtodayscashout()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{
  $currentdate = date('Y-m-d');
    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     //$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   $totalcashout = \DB::table('couttransfers')
   
    ->where('branchto', '=', $branchto)
    ->where('transferdate', '=', $currentdate)
    ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalcashout;
}

}
public function Branchtodaysexpenses()
{
   

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
   //  $dateinquestion  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
  //  $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
    $currentdate = date('Y-m-d');
   $totalexpenses = \DB::table('madeexpenses')
   
    ->where('branch', '=', $branchto)
    ->where('datemade', '=', $currentdate)
    ->where('approvalstate', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->sum('amount');
    return $totalexpenses;
}

}


public function geteditcashcollection()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcollectioncomponent-admin";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
//////////////////////////////////////////////////

public function getaddnewcashcredit()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcreditcomponent-admin";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function getdeletecashcredit()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcreditcomponent-admin";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function geteditcashcredit()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcreditcomponent-admin";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


































public function getaddnewcashcollection()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcollectioncomponent-admin";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function getdeletecashcollection()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "cashcollectioncomponent-admin";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}











public function geteditbranchexpenserecord()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchexpenserecords-branch";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function deletebranchexpenserecord()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchexpenserecords-branch";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
///////////////////////////////////////

public function getaddnewexpensetype()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensetypescomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function geteditexpensetype()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensetypescomponent";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
 
  
}

public function getdeleteexpensetype()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensetypescomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}


//////////////////////////////////////////////
public function getaddCompanyexpense()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "allcompanyexpenses";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function geteditCompanyexpense()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "allcompanyexpenses";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
 
  
}

public function deleteCompanyexpense()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "allcompanyexpenses";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}





public function getexpensecategoriesdy()
{
    $data = Expensescategory::get();

    return response()->json($data);
}


public function getexpensetypes()
{
    $data = Expensetype::get();

    return response()->json($data);
}





///////////////////////
public function getaddnewexpensecategory()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensecategoriescomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function geteditexpensecategory()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensecategoriescomponent";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
 
  
}

public function getdeleteexpensecategory()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "expensecategoriescomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}























































////////////////////////////////////////////////////////////////////////////////////////////////////
public function getAddnewuser()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchdetailscomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function getviewuser()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "userdetailscomponent";
$actonaddnew = 'viewdetails';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;

  
}


public function getedituser()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "userdetailscomponent";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
 
  
}

public function getdeleteuser()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "userdetailscomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}
/////////////////////////////////////////////////////////////////////////////////


public function Branchnametobalancefunction()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    ///getting the branch in question
    //$branchto  = \DB::table('branchtobalances') 
   //// ->where('ucret', '=', 68)
   //  ->get();
     //$branchto = \DB::table('branchtobalances')->select('branchnametobalance')->get();
     $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     $bnames  = Branch::where('branchno', $branchto)->value('branchname');
   
  //   $branchto = \DB::table('branchtobalances')->where('ucret', '=', 68)->get();
    // $bxn = $branchto['branchnametobalance'];
   // $bnames = \DB::table('branches')
   
  //  ->where('branchno', '=', $bnames)
    //->orderByDesc('id')
    //->limit(1)
  //  ->sum('clcash');
    return $bnames;
}



}

///// branch trandggdjh


////////////////////////////////////////////////////////////////////////////////////

public function getAddnewmainmenu()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "mainmenucomponentsvue";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function getAddnewbranch()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchdetailscomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}



public function getviewBranch()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchdetailscomponent";
$actonaddnew = 'viewdetails';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;

  
}




public function geteditBrabcg()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchdetailscomponent";
$actonaddnew = 'editrecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
 
  
}

public function getdeletebranch()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "branchdetailscomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}








////////////////////////////////////////////////
public function getRevokesubmenuaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "submenusettingscomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function getGrantsubmenuaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "submenucomponentsettoings";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
////////////////////////////////////////////////
public function getRevokecomponentaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "actualcoponentsaccesscontrol";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}

public function allowedtoviewshopBalancingRecord()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "shopbalancingcomponent";
$actonaddnew = 'viewdetails';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function allowedtodeleteshopBalancingRecord()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "shopbalancingcomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function allowedtoaddshopBalancingRecord()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "shopbalancingcomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
public function getGrantcomponentaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "mycomponentsaccess";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}
///////////////////////////////////////////////////////////////////























public function formfeaturesaccessComponent()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

$comp ='componentfeaturesdetails';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}




public function vuedetailsaccessComponent()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

$comp ='vuecomponentdetails';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}


public function submenuaccessComponent()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

$comp ='submenudetailscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}






public function fishmachinestotal()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
// $fishmachinestotal = "mainmenusettingscomponent";
// $actonaddnew = 'addnew';
$branchto = \DB::table('branchtobalances')->where('ucret', '=', $userid)->value('branchnametobalance');
 $wordCount = \DB::table('branchesandmachines')
   ->where('branchname', '=', $branchto)
  //  ->where('formcomponent', '=', $actonaddnew)
 //   ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function virtualgameproduct()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
// $component = "mainmenusettingscomponent";
$branchto = \DB::table('branchtobalances')->where('ucret', '=', $userid)->value('branchnametobalance');
$actonaddnew = 'virtual';

 $wordCount = \DB::table('branchandproducts')
 ->where('branch', '=', $branchto)
 ->where('sysname', '=', $actonaddnew)
//   ->where('rolein', '=', $udefinedrole)
 
    ->count();

    return $wordCount;
    
  
}

public function soccergameproduct()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

  $branchto = \DB::table('branchtobalances')->where('ucret', '=', $userid)->value('branchnametobalance');
  //$data = DB::table('users')->count();
  // $component = "mainmenusettingscomponent";
 
$actonaddnew = 'soccer';

 $wordCount = \DB::table('branchandproducts')
 ->where('branch', '=', $branchto)
 ->where('sysname', '=', $actonaddnew)
//   ->where('rolein', '=', $udefinedrole)
 
    ->count();

    return $wordCount;
    
  
}


public function fishgameproduct()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

  $branchto = \DB::table('branchtobalances')->where('ucret', '=', $userid)->value('branchnametobalance');
//$data = DB::table('users')->count();
// $component = "mainmenusettingscomponent";
$actonaddnew = 'fish';

 $wordCount = \DB::table('branchandproducts')
 ->where('branch', '=', $branchto)
 ->where('sysname', '=', $actonaddnew)
//   ->where('rolein', '=', $udefinedrole)
 
    ->count();

    return $wordCount;
    
  
}





public function getGrantmainmenuaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "mainmenusettingscomponent";
$actonaddnew = 'addnew';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
    
  
}


public function getRevokemainmenuaccess()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $udefinedrole =  auth('api')->user()->mmaderole;

//$data = DB::table('users')->count();
$component = "mainmenusettingscomponent";
$actonaddnew = 'deleterecord';

 $wordCount = \DB::table('mycomponentfeatures')
   ->where('component', '=', $component)
    ->where('formcomponent', '=', $actonaddnew)
    ->where('rolein', '=', $udefinedrole)
    ->count();

    return $wordCount;
  
}
///////////////////////////////////////////////////////////////l


public function machineoneopenningcode()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;
  
//////////// geting the shop to balance
//$branchto  = Currentmachinecode::latest('id')->where('branch', $userbranch)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
// $comp ='nebranchdetailscomponent';
$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
  $roleisallowedtoaccess = \DB::table('currentmachinecodes')

    ->where('branch', $branchto)->where('machineno', '101')->orderBy('id', 'Desc')->limit(1)->value('machinecode');

   return $roleisallowedtoaccess;
   ;
   
}

public function branchesaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='nebranchdetailscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

///


public function Currencysymbol()
{
    //getSinglebranchpayoutdaily
    $ed = '0';

 /// Getting the Logged in User details
 $userid =  auth('api')->user()->id;
 $userbranch =  auth('api')->user()->branch;
 $userrole =  auth('api')->user()->type;
 $compny =  auth('api')->user()->comp;
////getting the role system name
//$rolename = DB::table('roles')->select('userrole');
//if($rolename = 'admin')
{

    //   $branchto  = Branchtocollect::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
  
    $currentdate = date('Y-m-d');
   $companycu = \DB::table('companydetails')
   
    ->where('id', '=', $compny)
  //  ->where('transferdate', '=', $currentdate)
 //   ->where('status', '=', 1)
    //->orderByDesc('id')
    //->limit(1)
    ->value('currencysymbol');
    return $companycu;
}

}
public function branchcashInSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='shopcashinComp';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

public function branchcashOutSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='shopcashoutcomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function branchraccountbalancesSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='branchaccountscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function useraccountbalancesSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='useraccountscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}



public function branchesccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='branchdetailscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}





public function usersccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='userdetailscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

// public function branchcashInSettings()
// {
//   $userid =  auth('api')->user()->id;
//   $userbranch =  auth('api')->user()->branch;
//   $userrole =  auth('api')->user()->type;
//   $assignedrole =  auth('api')->user()->mmaderole;

// $comp ='shopcashinComp';
//  $roleisallowedtoaccess = \DB::table('componentsaccesses')

//     ->where('componentto', '=', $comp)
//     ->where('mmaderole', '=', $assignedrole)
//     ->count();

//     return $roleisallowedtoaccess;
   
// }





public function rolesaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

$comp ='rolesdecompnet';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}



// public function cashcollectionofficeaccessSetting()
// {
//   $userid =  auth('api')->user()->id;
//   $userbranch =  auth('api')->user()->branch;
//   $userrole =  auth('api')->user()->type;
//   $assignedrole =  auth('api')->user()->mmaderole;

// //////////// geting the shop to balance
// //$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
// //$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
// $comp ='branchexpenserecords-branch';
//  $roleisallowedtoaccess = \DB::table('componentsaccesses')

//     ->where('componentto', '=', $comp)
//     ->where('mmaderole', '=', $assignedrole)
//     ->count();

//     return $roleisallowedtoaccess;
   
// }




public function branchexpensesaccessSetting()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='branchexpenserecords-branch';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}



public function branchpayoutaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='payoutcomponent-branch';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}


public function shopbalancingaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='shopbalancingcomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

// public function submenuaccessSettings()
// {
//   $userid =  auth('api')->user()->id;
//   $userbranch =  auth('api')->user()->branch;
//   $userrole =  auth('api')->user()->type;
//   $assignedrole =  auth('api')->user()->mmaderole;

// //////////// geting the shop to balance
// //$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
// //$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
// $comp ='submenusettingscomponent';
//  $roleisallowedtoaccess = \DB::table('componentsaccesses')

//     ->where('componentto', '=', $comp)
//     ->where('mmaderole', '=', $assignedrole)
//     ->count();

//     return $roleisallowedtoaccess;
   
// }



public function mainmenuaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='mainmenusettingscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}

public function submenuaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='submenusettingscomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}


public function fishcreditaccessSetting()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='fishcreditcomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}


public function fishdebitaccessSetting()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='fishdebitcomponent';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function cashcreditaccessSetting()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='cashcreditcomponent-admin';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function cashcollectionaccessSetting()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='cashcollectioncomponent-admin';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}
public function featuresaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='componentfeatureaccess';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}




public function componentaccessSettings()
{
  $userid =  auth('api')->user()->id;
  $userbranch =  auth('api')->user()->branch;
  $userrole =  auth('api')->user()->type;
  $assignedrole =  auth('api')->user()->mmaderole;

//////////// geting the shop to balance
//$branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
//$dateinquestion  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('datedone');
$comp ='mycomponentsaccess';
 $roleisallowedtoaccess = \DB::table('componentsaccesses')

    ->where('componentto', '=', $comp)
    ->where('mmaderole', '=', $assignedrole)
    ->count();

    return $roleisallowedtoaccess;
   
}










































}