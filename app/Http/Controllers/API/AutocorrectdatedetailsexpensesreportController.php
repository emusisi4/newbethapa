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
use App\Madeexpense;
use App\Expdailyreport;
class AutocorrectdatedetailsexpensesreportController extends Controller
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
// sales summary
$newexpensestotal = \DB::table('madeexpenses')
->where('datemade', '=', $datedonessd)
->sum('amount');

//////////////////////////////////////////////////////////////////////////////
DB::table('expdailyreports')->where('datedone', $datedonessd)->delete();
    ///id, , , ucret, created_at, updated_at
Expdailyreport::Create([
  'amount'    => $newexpensestotal,
  'datedone'       => $datedonessd,
 
//   'yeardone'       => $monthmade,
//   'monthdone'      => $yearmade,
    
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
