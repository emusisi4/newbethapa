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
use App\Madeexpense;

class MonthlybranchexpensesController extends Controller
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
    //  id, startdate, enddate, branch, monthname, yearname, walletname, categoryname, typename, ucret, created_at, updated_at, sortby
     $branch = DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->value('branch');
     $monthtoview = DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->value('monthname');
     $yeartoview = DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->value('yearname');
    //  $reporyttype = DB::table('expensesreporttoviewdetails')->where('ucret', $userid)->value('reporttype');




     
      {
      
       return   Madeexpense::with(['branchName'])->orderby('amount', 'Desc')
   //   return   Dailyreportcode::latest('id')
        ->where('monthmade', $monthtoview)
        ->where('branch', $branch)
      //  ->whereBetween('datedone', [$startdat, $enddate])
       ->where('yearmade', $yeartoview)
       ->paginate(36);
      }



      
    }

  
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];
//// Getting the category
  
//$startdat = DB::table('incomereporttoviews')->where('ucret', $userid)->value('startdate');



       $this->validate($request,[
        'expense'   => 'required | String |max:191',
        'description'   => 'required',
        'amount'  => 'required',
        'datemade'  => 'required',
        'branch'  => 'required',
       // 'expensetype'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;
     $exp = $request['expense'];
     $expcat = \DB::table('expenses')->where('expenseno', $exp )->value('expensecategory');
//$expcat =  Expense::where('id', $exp)->value('expensecategory');
     $exptyo = \DB::table('expenses')->where('expenseno', $exp)->value('expensetype');
     
  //       $dats = $id;
       return Madeexpense::Create([
      'expense' => $request['expense'],
     //'expenseno' => $hid,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'datemade' => $request['datemade'],
      'branch' => $request['branch'],
      'category' => $expcat,
      'exptype' => $exptyo,
      'ucret' => $userid,
    
  ]);
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

        $user = Madeexpense::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
