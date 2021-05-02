<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Orderssummary;
use App\Saleview;

use App\Productsale;
use App\Ordermaking;


class SelectedreceipttoviewController extends Controller
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
/// Getting the active record to view
$ordertovire  = Saleview::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('ordertoview'); 
    //  if($userrole == '101')
      {
    
   return   Productsale::with(['productName','brandName'])->latest('id')
  // return   Productsale::latest('id')
       //  return   Branchpayout::latest('id')
        ->where('invoiceno', $ordertovire)
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

        

        /// Getting the cost of the to be deleted item
      //  $currentlinecost  = Orderdetail::where('id', $id)->value('linetotalcost');  
        $currentinvoiceno  = Orderdetail::where('id', $id)->value('invoiceno'); 
        $currentlinecost = \DB::table('orderdetails')->where('id', '=', $id)->value('linetotalcost');

        /// gettint the total invoice
       $currentinvoiceamount  = Orderssummary::where('invoiceno', $currentinvoiceno)->value('invoiceamount'); 
 
        $currentlinecost = \DB::table('orderdetails')->where('id', '=', $id)->value('linetotalcost');
 
        ///
        $newinvoiceamount =  $currentinvoiceamount-$currentlinecost;
       
 DB::table('orderssummaries')->where('invoiceno', $currentinvoiceno)->update(['invoiceamount' =>$newinvoiceamount]);

 $user = Orderdetail::findOrFail($id);
 $user->delete();

    }
}
