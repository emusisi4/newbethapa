<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Cintransfer;
use App\Userbalance;
use App\Cashtransfer;
class UsercashoutdetailsController extends Controller
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
         
     
     if($userrole != '100')
     {      
        return   Cashtransfer::with(['usernameTransferfrom', 'usernameTransferto'])->latest('id')
      
      ->where('transferfrom', $userid)
      ->paginate(30);
    }

      
    

      
    }

  
    
    public function store(Request $request)
    {
      
      $this->validate($request,[
        'transferto'   => 'required |max:191',
        'description'   => 'required',
        'amount'  => 'required',
        'transerdate'  => 'required',
     
    
     ]);


     $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;
     
     
     
     $yfg = $request['transerdate'];
     $yeardone = date('Y', strtotime($yfg));
     $monthdone = date('m', strtotime($yfg));

/// cgetting the current Amount for the Person who sent
$transferamount = $request['amount'];
$sendersbalance  = Userbalance::where('username', $userid)->value('amount');
     

if($sendersbalance >= $transferamount )
{

  //       $dats = $id;
       return Cashtransfer::Create([
      'transferto' => $request['transferto'],
      'branchfrom' => $userbranch,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'transerdate' => $request['transerdate'],
      'transferfrom' => $userid,
      'yeardone' => $yeardone,
      'monthdone' => $monthdone,
      'ucret' => $userid,
    
  ]);
       }////
    }

    
    
    public function show($id)
    {
        //
    }
   
  
    
    public function update(Request $request, $id)
    {
        //
        $user = Cashtransfer::findOrfail($id);

$this->validate($request,[
  'transferto'   => 'required |max:191',
  'description'   => 'required',
  'amount'  => 'required',
  'transerdate'  => 'required',
]);

 
     
$user->update($request->all());
    }

 
    
    public function destroy($id)
    {
        //
     //   $this->authorize('isAdmin'); 

        $user = Cashtransfer::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }



}
