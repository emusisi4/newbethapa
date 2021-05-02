<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Branch;
use App\Product;
use App\Shopingcat;
use App\Productsale;
use App\Ordermaking;

class OrdermakingController extends Controller
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
    
        return   Ordermaking::with(['producttoorderName','brandName','unitMeasure','productSupplier'])->latest('id')
  ///  return   Product::latest('id')
       //  return   Branchpayout::latest('id')
        // ->where('branch', $userbranch)
        ->paginate(20);
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
       'productname'   => 'required',
       'brand'   => 'required',
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =  auth('api')->user()->id;
     $branch =  auth('api')->user()->branch;
  $datepaid = date('Y-m-d');

  
/// getting the Unit Price
$product = $request['productcode'];
$unitprice = \DB::table('productstocks') ->where('productcode', '=', $product)->value('unitprice');

/// checking if the product is on the cart
$productexistsoncart = \DB::table('shopingcats')->where('productcode', '=', $product)->where('ucret', '=', $userid)->count();
if($productexistsoncart < 1)
{
        Shopingcat::Create([
    
  //    'productcode' => $request['productcode'],
      'productname' => $request['productname'],
      'brand' => $request['brand'],
      'supplier' => $request['supplier'],
      'unitmeasure' => $request['unitmeasure'],
      'quantity' => $request['quantity'],
      'unitcost' => $request['unitcost'],
      'smallunitmeasure' => $request['smallunitmeasure'],
     
     // 'datesold' => $datepaid,
      //'branch' => $branch,
      'unitprice' => $unitprice,
      'linetotal' => ($unitprice*( $request['quantity'])),
     
      'ucret' => $userid,
    
  ]);
        }

        if($productexistsoncart > 0)
{
  $currentquantity = \DB::table('shopingcats') ->where('productcode', '=', $product)->where('ucret', '=', $userid)->value('quantity');
 
$newquantity = $request['quantity']+$currentquantity;
  
$result = DB::table('shopingcats')
    ->where('productcode', $product)
    ->update([
      'quantity' => $newquantity,
      'linetotal' => (($newquantity*$unitprice))
    ]);
  
     
        }
  //$datas =\DB::table('shopingcats')->get();

//  //foreach($datas as $data){
//   $users = DB::table('shopingcats')->where('ucret', $userid)->get();
    
//   foreach ($users as $user) {
    
//    Productsale::Create([
//     'productcode' => $user->productcode,
//     'unitprice' => $user->unitprice,       
            
//              'ucret' => $userid,
           
//          ]);
     
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
        $user = Shopingcat::findOrfail($id);

$this->validate($request,[
  'productcode'   => 'required',
  'unitprice'   => 'required',
  'quantity'   => 'required'

    ]);

    $user->update([
        'productcode' =>  $request['productcode'],
        'quantity' => $request['quantity'],
        'unitprice' => (($request['unitprice'])),
        'linetotal' => (($request['quantity']*$request['unitprice'])),
       // 'password' => $request->input('password', $user->password),
    ]);
     
///$user->update($request->all());
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

        $user = Shopingcat::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
