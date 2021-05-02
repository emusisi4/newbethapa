<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Productcategory;
use App\Expensescategory;

class ExpensecategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    //  return   Product::with(['userbalancingBranch','branchinBalance'])->latest('id')
   // return   Productcategory::with(['brandName','productCategory','productSupplier','unitMeasure'])->latest('id')
      return   Expensescategory::latest('id')
       //  return   Branchpayout::latest('id')
        // ->where('branch', $userbranch)
        ->paginate(20);
      }


     // if($userrole == '100')
      {
      
      
     // return   Product::with(['userbalancingBranch','branchinBalance'])->latest('id')
      
      // return   Product::latest('id')
       //  return   Branchpayout::latest('id')
    //     ->where('del', 0)
     //   ->paginate(20);
      
    }
      
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



       $this->validate($request,[
        'expcatcatname'   => 'required  |max:191',
      'description'   => 'required'
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;

  $datepaid = date('Y-m-d');
//  $inpbranch = $request['branchnametobalance'];

$dateinq =  $request['datedone'];


       return Expensescategory::Create([
    

      'expcatcatname' => $request['expcatcatname'],
     
      'description' => $request['description'],
     
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
   
    public function update(Request $request, $id)
    {
        //
        $user = Expensescategory::findOrfail($id);

$this->validate($request,[
    'expcatcatname'   => 'required  |max:191',
    'description'   => 'required'
  

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

        $user = Expensescategory::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
