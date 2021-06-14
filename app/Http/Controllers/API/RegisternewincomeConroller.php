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
use App\Companyincome;

class RegisternewincomeConroller extends Controller
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
      
         return   Madeexpense::with(['branchName','expenseName'])->latest('id')
  
        ->where('del', 0)
        ->where('branch', $userbranch)
        ->where('explevel', 1)
       ->paginate(30);
      }
      if($userrole != '101')
      {
      
         return   Madeexpense::with(['branchName','expenseName'])->latest('id')
 
        ->where('del', 0)
        ->paginate(20);
      }

            return   Madeexpense::get()->count();


     
    }

  
    public function store(Request $request)
    {
       
        

       $this->validate($request,[
        'incomesource'   => 'required',
        'description'   => 'required',
        'amount'  => 'required',
        'daterecieved'  => 'required',
     ]);


     $userid =  auth('api')->user()->id;
     $dateinact = $request['daterecieved'];
     $yearmade = date('Y', strtotime($dateinact));
     $monthmade = date('m', strtotime($dateinact));
     ////////////////////
       return Companyincome::Create([
      'incomesource' => $request['incomesource'],
  
      'description' => $request['description'],
      'amount' => $request['amount'],
      'daterecieved' => $request['daterecieved'],
      'ucret' => $userid,
      'yearmade' => $yearmade,
      'monthmade' => $monthmade,
      
    
  ]);
    }

    
    public function show($id)
    {
        //
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

        $user = Madeexpense::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
