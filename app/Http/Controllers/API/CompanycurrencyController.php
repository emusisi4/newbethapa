<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Companydetail;

class CompanycurrencyController extends Controller
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
     //   if($userrole = 1)
        {
        return Companydetail::latest()
      //  -> where('ucret', $userid)
        ->paginate(25);
        }

      
    }

  
    public function store(Request $request)
    {
       

       $this->validate($request,[
        'mainmenuname'   => 'required',
       'iconclass'   => 'required',
        'dorder'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $id1  = Mainmenucomponent::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('id');
     $hid = $id1+1;

  
     
  //       $dats = $id;
       return Mainmenucomponent::Create([
      'mainmenuname' => $request['mainmenuname'],
   //  'hid' => $hid,
      'dorder' => $request['dorder'],
      'iconclass' => $request['iconclass'],
 
      'ucret' => $userid,
    
  ]);
    }

   
    public function show($id)
    {
        //
    }
   
  
    public function update(Request $request, $id)
    {
        //
        $user = Mainmenucomponent::findOrfail($id);

$this->validate($request,[
    'mainmenuname'   => 'required',
    'iconclass'   => 'required',
    'dorder'   => 'sometimes |min:0'

    ]);


$user->update($request->all());
    }

  
    
    public function destroy($id)
    {
        //
     //   $this->authorize('isAdmin'); 

        $user = Mainmenucomponent::findOrFail($id);
        $user->delete();
    

    }
}
