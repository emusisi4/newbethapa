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
use App\Mlyrpt;
use App\Monthlyreporttoviewallbranch;

class MonthlyreportsallbranchesController extends Controller
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

        $reporttype = \DB::table('monthlyreporttoviewallbranches')->where('ucret', '=', $userid)->value('reporttype');
        $monthtodisplay = \DB::table('monthlyreporttoviewallbranches')->where('ucret', '=', $userid)->value('monthmade');
        $yeartodisplay = \DB::table('monthlyreporttoviewallbranches')->where('ucret', '=', $userid)->value('yearmade');
        $branch = \DB::table('monthlyreporttoviewallbranches')->where('ucret', '=', $userid)->value('branch');
       // $branch = \DB::table('monthlyreporttoviewallbranches')->where('ucret', '=', $userid)->value('branchname');
        
    // if($reporttype == 'salesreport')
      {
        
      
    if($branch == "900")
    {
      return   Mlyrpt::with(['branchnameDailycodes'])->orderby('id', 'Asc')
     
   ->where('yeardone', $yeartodisplay)
   ->where('monthdone', $monthtodisplay)
    //   ->where('yearmade', $yeartodisplay)
       ->paginate(35);
    }
    if($branch != "900")
    {
      return   Mlyrpt::with(['branchnameDailycodes'])->orderby('id', 'Asc')
    
   ->where('yeardone', $yeartodisplay)
   ->where('monthdone', $monthtodisplay)
   ->where('branch', $branch)
       ->paginate(35);
    }
  
      }
     
    

      
    }


    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];

       
       $this->validate($request,[
       // 'branchname'   => 'required',
        'monthname'   => 'required',
        'yearname'   => 'required',
     
         //'sortreportby'   => 'required'
     ]);


     $userid =  auth('api')->user()->id;
     
 //  $reptov = $request['actionaidsalesreportbydate'];
  // DB::table('expensereporttoviews')->where('ucret', $userid)->where('reporttype',$reptov)->delete();
  DB::table('monthlyreporttoviewallbranches')->where('ucret', $userid)->delete();
  $datepaid = date('Y-m-d');
    
       return Monthlyreporttoviewallbranch::Create([
      
       'monthmade' => $request['monthname'],
      'yearmade' => $request['yearname'],
      'branch' => $request['branchname'],
   //   'reporttype' => $request['sortreportby'],
 
      'ucret' => $userid,
     
    
  ]);











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
