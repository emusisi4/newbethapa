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
use App\Productdelivery;
use App\Productprice;
use App\Productquantity;

class ItemdeliveryController extends Controller
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
    
        return   Ordermaking::with(['producttoorderName','brandName','unitMeasure','productSupplier'])->latest('id')
 
        ->paginate(20);
      }


      
    }

    
    
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
       'productname'   => 'required',
       'brand'   => 'required',
       'sellingprice'   => 'required',
       'deliveringsupplier'   => 'required',
       'deliveringunitofmeasure' => 'required',
       'deliveringquantity' => 'required',
       'deliveringqtyperunit' => 'required',
       'deliveringsmallunitmeasure' => 'required',
       'invoiceno' => 'required',
       // 'dorder'   => 'sometimes |min:0'
     ]);
     $userid =   auth('api')->user()->id;
     $branch =   auth('api')->user()->branch;
     $datepaid = date('Y-m-d');

  
/// getting the Unit Price
$invoiceno = $request['invoiceno'];

$product = $request['productname'];
$recordto = $request['id'];

//if($productexistsoncart < 1)
{
  $totalunitsdelivered = $request['deliveringquantity'];
  $quantitydeliveredforeachunit = $request['deliveringqtyperunit'];
  $totalsmallestunitsdelivered = $totalunitsdelivered*$quantitydeliveredforeachunit;
  Productdelivery::Create([
    
  
      'productname' => $request['productname'],
      'orderdate' => $request['datemade'],
     
      'qtyordered' => $request['quantity'],
      'ordersupplier' => $request['supplier'],
      'orderingmainunit' => $request['unitofmeasure'],
      'orderingsmallunit' => $request['smallunitmeasure'],
      'orderingqtyperunit' => $request['qtyperunit'],
      'orderingbrand' => $request['brand'],
      'costpriceforunit' => $request['unitcost'],
      'linecostprice' => $request['lineunitcost'],
      'deliveringmainunit' => $request['deliveringunitofmeasure'],
      'qtyofunitsdelivered' => $request['deliveringquantity'],
     

      'qtyperunitdelivered' => $request['deliveringqtyperunit'],
      'smallunitdelivered' => $request['deliveringsmallunitmeasure'],
      'sellingprice' => $request['sellingprice'],

      'deliveringsupplier' => $request['deliveringsupplier'],
      //'linetotal' => ($unitprice*( $request['quantity'])),
     
      'ucret' => $userid,
    
  ]);

  $prod = $request['productname'];
  /// Getting the product current quantity
  
  Productprice::Create([
    
  
    'productcode' => $request['productname'],
    //'orderdate' => $request['datemade'],
   
    'unitcost' => $request['lineunitcost'],
    'unitprice' => $request['sellingprice'],
    
    'lineprofit' => ($request['sellingprice']-( $request['lineunitcost'])),
   'profitperc' => 100*($request['lineunitcost']/( $request['sellingprice'])),
    'ucret' => $userid,
  
]);
        }
        $totalsmallestunitsdeliveredone = $totalunitsdelivered*$quantitydeliveredforeachunit;

        $ews1 = \DB::table('products') ->where('id', '=', $prod)->value('qty');//
        $addedquantityone = $totalsmallestunitsdeliveredone;
        $newproductquantity = $ews1+$addedquantityone;
      ////
      $rot = DB::table('products')->where('id', $prod)->update(['qty' => $newproductquantity ]);














$result = DB::table('orderdetails')  ->where('id', $recordto)->update(['orderdeliverystatus' => 1 ]);
  
//// Getting the product existance in product quantitties
$productisthere = \DB::table('productquantities')->where('productcode', '=', $prod) ->count();

if($productisthere < 1)
{
  $currentproductquantity = \DB::table('productquantities') ->where('productcode', '=', $product)->value('qty');//
  $addedquantity = $totalsmallestunitsdelivered;
  $newproductquantity = $currentproductquantity+$addedquantity;
////
Productquantity::Create(['productcode' => $request['productname'],
'qty' => $newproductquantity,
'ucret' => $userid,

]);
  //$rot = DB::table('productquantities')->where('productcode', $prod)->update(['qty' => $newproductquantity ]);
}

if($productisthere > 0)
{
  $currentproductquantity = \DB::table('productquantities') ->where('productcode', '=', $product)->value('qty');//
  $addedquantity = $totalsmallestunitsdelivered;
  $newproductquantity = $currentproductquantity+$addedquantity;

  $rot = DB::table('productquantities')->where('productcode', $prod)->update(['qty' => $newproductquantity ]);
}
  
  
}


 
    public function show($id)
    {
        //
    }
   
  

     
    public function update(Request $request, $id)
    {
        //
     $user = Productdelivery::findOrfail($id);

 $this->validate($request,[
  'productname'   => 'required',
  'sellingprice'   => 'required',
  'deliveringsmallunitmeasure'   => 'required',
  'deliveringqtyperunit'   => 'required',
  'deliveringquantity'   => 'required',
  'deliveringunitofmeasure'   => 'required',
  'deliveringsupplier'  => 'required'

    ]);
$prod = $request['productname'];
    Productdelivery::Create([
    
  
            'productname' => $request['productname'],
            'orderdate' => $request['orderdate'],
            'qtyordered' => $request['supplier'],
            'unitmeasure' => $request['unitmeasure'],
            'quantity' => $request['quantity'],
            'unitcost' => $request['unitcost'],
            'smallunitmeasure' => $request['smallunitmeasure'],
            'unitprice' => $unitprice,
            'linetotal' => ($unitprice*( $request['quantity'])),
           
            'ucret' => $userid,
          
        ]);
    

    }
    public function destroy($id)
    {
        //
     //   $this->authorize('isAdmin'); 

        $user = Shopingcat::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
