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
class ExpensesreporttoviewdetailcategoryController extends Controller
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
        // $walletname = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('walletname');
        // $typename = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('typename');
        // $sort = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('sortby');

        $startdat = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('startdate');
        $enddate = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('enddate');

       
        $categoryname = \DB::table('expensesreporttoviewdetails')->where('ucret', '=', $userid)->value('categoryname');
      


        if($categoryname == '900')
        {
           
                return   Madeexpense::with(['branchnameDailycodes','expenseName','expenseCategoryrpt','expenseWallet','expenseTyperpt'])->orderby('amount', 'Desc')
             
                
                ->whereBetween('datemade', [$startdat, $enddate])
                ->paginate(35);
        }
            


if($categoryname != "900")
{
   
    return   Madeexpense::with(['branchnameDailycodes','expenseName','expenseCategoryrpt','expenseWallet','expenseTyperpt'])->orderby('amount', 'Desc')
             
           
        //    ->where('yearmade', $yeartodisplay)
        //    ->where('monthmade', $monthtodisplay)
        ->whereBetween('datemade', [$startdat, $enddate])
        ->where('category', $categoryname)
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
  

  
     Expensesreporttoviewdetail::Create([
     
      
      'monthname' => $request['monthname'],
     'yearname' => $request['yearname'],
      'branch' => $request['branchname'],
      'startdate' => $request['startdate'],
      'enddate' => $request['enddate'],
      
      'categoryname' => $request['categoryname'],
      
      'sortby' => 'category',

      'ucret' => $userid,
     
    
  ]);
       //
       }









    }
///////////////////////////////////////////////////////////////////////

























    public function show($id)
    {
        //
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
