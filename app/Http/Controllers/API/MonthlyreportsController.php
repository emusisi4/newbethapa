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
use App\Monthlyreporttoview;
use App\Salesdetail;

class MonthlyreportsController extends Controller
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

        $reporttype = \DB::table('monthlyreporttoviews')->where('ucret', '=', $userid)->value('reporttype');
        $monthtodisplay = \DB::table('monthlyreporttoviews')->where('ucret', '=', $userid)->value('monthname');
        $yeartodisplay = \DB::table('monthlyreporttoviews')->where('ucret', '=', $userid)->value('yearname');
        $branch = \DB::table('monthlyreporttoviews')->where('ucret', '=', $userid)->value('branchname');
        
    // if($reporttype == 'salesreport')
      {
        
      //   return   Dailyreportcode::with(['branchName','expenseName'])->latest('id')
      return   Dailyreportcode::with(['branchnameDailycodes', 'machinenameDailycodes'])->orderby('datedone', 'Asc')
       //return   Dailyreportcode::orderBy('daysalesamount', 'Desc')
        ->where('monthmade', $monthtodisplay)
        ->where('branch', $branch)
        ->where('yearmade', $yeartodisplay)
        ->paginate(35);
      }
     
    

      
    }


    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];

       
       $this->validate($request,[
        'branchname'   => 'required',
        'monthname'   => 'required',
        'yearname'   => 'required',
     
         'reporttype'   => 'required'
     ]);


     $userid =  auth('api')->user()->id;
     
 //  $reptov = $request['actionaidsalesreportbydate'];
  // DB::table('expensereporttoviews')->where('ucret', $userid)->where('reporttype',$reptov)->delete();
  DB::table('monthlyreporttoviews')->where('ucret', $userid)->delete();
  $datepaid = date('Y-m-d');
    
       return Monthlyreporttoview::Create([
      
       'monthname' => $request['monthname'],
      'yearname' => $request['yearname'],
      'branchname' => $request['branchname'],
      'reporttype' => $request['reporttype'],
 
      'ucret' => $userid,
     
    
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
