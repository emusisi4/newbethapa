<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Product;

class CompanyproductsController extends Controller
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
    //  return   Product::with(['userbalancingBranch','branchinBalance'])->latest('id')
    return   Product::with(['brandName','productCategory','productSupplier','unitMeasure'])->latest('id')
    ///  return   Product::latest('id')
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

   
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
      'name'   => 'required  |max:191',
      'brand'   => 'required',
      'unitmeasure'   => 'required',
      'brand'   => 'required', 
      'category'   => 'required'
    //   'unitname'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;

  $datepaid = date('Y-m-d');
//  $inpbranch = $request['branchnametobalance'];

$dateinq =  $request['datedone'];
$productcode  = \DB::table('products')->orderBy('id', 'Desc')->limit(1)->value('id');

       return Product::Create([
    
  //    'productcode' => $request['productcode'],
      'name' => $request['name'],
      'rol' => $request['rol'],
      'category' => $request['category'],
      'brand' => $request['brand'],
     // 'supplier' => $request['supplier'],
      'unitmeasure' =>$request['unitmeasure'],
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
        $user = Product::findOrfail($id);

$this->validate($request,[
  //'branchname'   => 'required | String |max:191'
  

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

        $user = Product::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
