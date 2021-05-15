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
use App\Branchtocollect;
use App\Incomereporttoview;
use App\Expensereporttoview;
use App\Fishreportselection;
use App\Dailyreportcode;

class FishreporttoviewController extends Controller
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


     //if($userrole == '101')
     // {
      //FishreporttoviewController
      // $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
      $datetoview = \DB::table('sortlistreportaccesses')->where('ucret', '=', $userid)
      //->where('ucret', '=', $userid)
      ->value('startdate');
      $sortby = \DB::table('sortlistreportaccesses')->where('ucret', '=', $userid)
      //->where('ucret', '=', $userid)
      ->value('sortname');
      //   return   Dailyreportcode::with(['branchName','expenseName'])->latest('id')
      if($sortby == 'datesort')
      {
      return   Dailyreportcode::with(['branchnameDailycodes', 'machinenameDailycodes'])->orderBy('datedone', 'DESC')
       //return   Dailyreportcode::orderBy('daysalesamount', 'Desc')
       //->where('del', 0)
       ->where('datedone', $datetoview)
      //  ->where('explevel', 1)
       ->paginate(35);
      }
      if($sortby == 'salessort')
      {
    //  return   Dailyreportcode::with(['branchnameDailycodes', 'machinenameDailycodes'])->orderBy('dorder', 'Asc')
      return   Dailyreportcode::with(['branchnameDailycodes', 'machinenameDailycodes'])->orderBy('daysalesamount', 'DESC')
       //return   Dailyreportcode::orderBy('daysalesamount', 'Desc')
       // ->where('del', 0)
      //  ->where('branch', $userbranch)
      ->where('datedone', $datetoview)
       ->paginate(40);
      }
     


       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();

   //   return   Branchpayout::with(['ExpenseTypeconnect','expenseCategory','payingUserdetails'])->latest('id')
     //  return   Branchpayout::latest('id')
     //   ->where('del', 0)
     //  ->paginate(13);

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


       $this->validate($request,[
        'branchnametobalance'   => 'required | String |max:191',
        'startdate'   => 'required',
         'enddate'   => 'required'
     ]);


     $userid =  auth('api')->user()->id;
   //  $userbranch =  auth('api')->user()->branch;
   //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
   //  $hid = $id1+1;
   $reptov = $request['actionaid'];
  // DB::table('expensereporttoviews')->where('ucret', $userid)->where('reporttype',$reptov)->delete();
  DB::table('fishreportselections')->where('ucret', $userid)->delete();
  $datepaid = date('Y-m-d');
     
  //       $dats = $id;




  if($reptov == "fishreportbydateandbranch")
  {
       return Fishreportselection::Create([
      'branch' => $request['branchnametobalance'],
      'startdate' => $request['startdate'],
      'reporttype' => $request['actionaid'],
      'enddate' => $request['enddate'],
 
      'ucret' => $userid,
     
    
  ]);
}///


if($reptov == "salesdetailsbybranch")
{
     return Fishreportselection::Create([
    'branch' => $request['branchnametobalance'],
    'startdate' => $request['startdate'],
    'reporttype' => $request['actionaid'],
    'enddate' => $request['enddate'],

    'ucret' => $userid,
   
  
]);
}///


if($reptov == "expreportbywallet")
{
     return Expensereporttoview::Create([
    'branch' => $request['branchnametobalance'],
    'startdate' => $request['startdate'],
    'reporttype' => $request['actionaid'],
    'enddate' => $request['enddate'],

    'ucret' => $userid,
   
  
]);
}///









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

        $user = Branchpayout::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
