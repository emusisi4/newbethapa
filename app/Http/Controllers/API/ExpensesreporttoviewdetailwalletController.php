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
use App\Expensesreporttoviewdetail;
use App\Madeexpense;
class ExpensesreporttoviewdetailwalletController extends Controller
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
    //  id, startdate, enddate, branch, monthname, yearname, walletname, categoryname, typename, ucret, created_at, updated_at, sortby
    //  $reporttype = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('reporttype');
      // $monthtodisplay = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('monthname');
      // $yeartodisplay = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('yearname');
      // $branch = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('branch');
       $walletname = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('walletname');
      // $typename = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('typename');
      // $sort = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('sortby');

      $startdat = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('startdate');
      $enddate = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('enddate');

     
      

      if($walletname == '900')
      {
         
        return   Madeexpense::with(['branchnameDailycodes','expenseName','expenseCategoryrpt','expenseWallet','expenseTyperpt'])->orderby('amount', 'Desc')->orderby('created_at', 'Desc')->orderby('walletexpense', 'Desc')
           
               
              //    ->where('yearmade', $yeartodisplay)
              //    ->where('monthmade', $monthtodisplay)
              ->whereBetween('datemade', [$startdat, $enddate])
            
              ////    ->where('branch', $branch)
                  ->paginate(35);
      }


      if($walletname != '900')
      {
         
        return   Madeexpense::with(['branchnameDailycodes','expenseName','expenseCategoryrpt','expenseWallet','expenseTyperpt'])->orderby('amount', 'Desc')->orderby('created_at', 'Desc')->orderby('walletexpense', 'Desc')
           
           
              //    ->where('yearmade', $yeartodisplay)
              //    ->where('monthmade', $monthtodisplay)
              ->whereBetween('datemade', [$startdat, $enddate])
              ->where('walletexpense', $walletname)
              ////    ->where('branch', $branch)
                  ->paginate(35);
      }
    }

 
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];
       $userid =  auth('api')->user()->id;
       $userbranch =  auth('api')->user()->branch;
       $userrole =  auth('api')->user()->type;
       $reptov1 = $request['actionaidformonthlyreportvexp'];
      //  $reptov2 = $request['actionforbranchmonthlyexpenses'];
       
      // if($reptov1  = "branchmonthlyexpensesrpt")
       {
          $this->validate($request,[
      //   'branchname' => 'required',
       // 'monthname'   => 'required',
       //  'yearname'   => 'required'
     ]);
     DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->delete();
    $repty =  $request['sortbycat'];

  
     Expensesreporttoviewdetail::Create([
      //id, startdate, enddate, branch, monthname, yearname, walletname, categoryname, typename, ucret, created_at, updated_at, sortby
      // 'sortby' => $reptov1,
      
      'monthname' => $request['monthname'],
     'yearname' => $request['yearname'],
      'branch' => $request['branchname'],
      'startdate' => $request['startdate'],
      'enddate' => $request['enddate'],
      'walletname' => $request['walletname'],
      'categoryname' => $request['categoryname'],
      'typename' => $request['typename'],
      'sortby' => 'wallet',

      'ucret' => $userid,
     
    
  ]);
       //
       }



//      if($reptov1  == "monthlyexpensereportsummary")
//        {
//            $this->validate($request,[
      
//     'monthname'   => 'required',
//     'yearname'   => 'required'
//     ]);
//    DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->delete();
//     Expensesreporttoviewdetail::Create([
      
   
//      'monthname' => $request['monthname'],
//      'yearname' => $request['yearname'],
 
//      'ucret' => $userid,
     
    
//  ]);
//        }
      


//      $userid =  auth('api')->user()->id;
//    //  $userbranch =  auth('api')->user()->branch;
//    //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
//    //  $hid = $id1+1;
//    $reptov = $request['actionaid'];
//   // DB::table('expensereporttoviews')->where('ucret', $userid)->where('reporttype',$reptov)->delete();
//   DB::table('expensereporttoviews')->where('ucret', $userid)->delete();
//   $datepaid = date('Y-m-d');
     
//   //       $dats = $id;




//   if($reptov == "expreportbybranch")
//   {
//        return Expensereporttoview::Create([
//       'branch' => $request['branchnametobalance'],
//       'startdate' => $request['startdate'],
//       'reporttype' => $request['actionaid'],
//       'enddate' => $request['enddate'],
 
//       'ucret' => $userid,
     
    
//   ]);
// }///


// if($reptov == "salesdetailsbybranch")
// {
//      return Expensereporttoview::Create([
//     'branch' => $request['branchnametobalance'],
//     'startdate' => $request['startdate'],
//     'reporttype' => $request['actionaid'],
//     'enddate' => $request['enddate'],

//     'ucret' => $userid,
   
  
// ]);
// }///


// if($reptov == "expreportbywallet")
// {
//      return Expensereporttoview::Create([
//     'branch' => $request['branchnametobalance'],
//     'startdate' => $request['startdate'],
//     'reporttype' => $request['actionaid'],
//     'enddate' => $request['enddate'],

//     'ucret' => $userid,
   
  
// ]);
// }///









    }
///////////////////////////////////////////////////////////////////////

























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
