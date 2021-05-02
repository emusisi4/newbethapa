<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Branchpayout;

class BranchpayoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
 $this->middleware('auth:api');
//       $this->authorize('isAdmin'); 
    }

    public function index()
    {
$userid =  auth('api')->user()->id;
$userbranch =  auth('api')->user()->branch;
$userrole =  auth('api')->user()->type;





     //   if($userrole = 1)





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();

     $currentdate = date("Y-m-d");
     if($userrole == "101")
     {
      return   Branchpayout::with(['ExpenseTypeconnect','expenseCategory','payingUserdetails'])->latest('id')
     //  return   Branchpayout::latest('id')
        ->where('del', 0)
        ->where('bpaying', $userbranch)
        ->where('datepaid', $currentdate)
       ->paginate(13);
     }

     if($userrole == '100')
     {
    //  $this->authorize('isAdmin'); 
      return   Branchpayout::with(['ExpenseTypeconnect','expenseCategory','payingUserdetails'])->latest('datepaid')
     //  return   Branchpayout::latest('id')
        ->where('del', 0)
      //  ->where('bpaying', $userbranch)
       // ->where('datepaid', $currentdate)
       ->paginate(13);
     }

     
       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           










       // {
      // return Submheader::latest()
      //  -> where('ucret', $userid)
    //    ->paginate(15);
      //  }

      
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

/*
  $this->validate($request,[
        'receiptno'   => 'required | String |max:191',
        'datemade'   => 'required',
        'branchpayingtheticket' => 'required',
        'branch'  => 'required',
        'amount'  => 'required'
        //'amount'   => 'sometimes |min:0'
     ]);

*/
$userid =  auth('api')->user()->id;
$userbranch =  auth('api')->user()->branch;
$userrole =  auth('api')->user()->type;
if($userrole == '101')
{
       $this->validate($request,[
        'receiptno'   => 'required | String |max:191',
        'datemade'   => 'required',
       // 'branchpayingtheticket' => 'required',
        'branch'  => 'required',
        'amount'  => 'required'
        //'amount'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
   //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
   //  $hid = $id1+1;

  $datepaid = date('Y-m-d');
     
  //       $dats = $id;
       return Branchpayout::Create([
      'receiptno' => $request['receiptno'],
      'bpaying' =>  $userbranch,
      'datemade' => $request['datemade'],
      'branch' => $request['branch'],
      'amount' => $request['amount'],
      'datepaid' => $datepaid,
      'paymentdate' => $datepaid,
     // 'mainheadercategory' => $request['mainheadercategory'],
 
      'ucret' => $userid,
    
  ]);

       }/// closing the if
       if($userrole == '100')
       {
              $this->validate($request,[
               'receiptno'   => 'required | String |max:191',
               'datemade'   => 'required',
               'branchpayingtheticket' => 'required',
               'datepaidd' => 'required',
               'branch'  => 'required',
               'amount'  => 'required'
               //'amount'   => 'sometimes |min:0'
            ]);
       
       
            $userid =  auth('api')->user()->id;
            $userbranch =  auth('api')->user()->branch;
          //  $id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
          //  $hid = $id1+1;
       
         $datepaid = date('Y-m-d');
            
         //       $dats = $id;
              return Branchpayout::Create([
             'receiptno' => $request['receiptno'],
             'bpaying' =>  $request['branchpayingtheticket'],
             'datemade' => $request['datemade'],
             'branch' => $request['branch'],
             'amount' => $request['amount'],
             'datepaid' => $request['datepaidd'],
             'paymentdate' => $request['datepaidd'],
            // 'mainheadercategory' => $request['mainheadercategory'],
        
             'ucret' => $userid,
           
         ]);
       
              }/// closing the if
       



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
