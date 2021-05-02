<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;

class SubmenusController extends Controller
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
     //   if($userrole = 1)





       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();


      
         return   Submheader::with(['maincomponentSubmenus'])->latest('id')
        ->where('del', 0)
       ->paginate(15);

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



       $this->validate($request,[
       'submenuname'   => 'required | String |max:191',
       'mainheadercategory'   => 'required',
       'linkrouterre'   => 'required | String |max:191',
       'description'   => 'required',
       'dorder'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     $id1  = Submheader::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('shid');
     $hid = $id1+1;

  
     
  //       $dats = $id;
       return Submheader::Create([
      'submenuname' => $request['submenuname'],
     'shid' => $hid,
      'dorder' => $request['dorder'],
      'linkrouterre' => $request['linkrouterre'],
      'description' => $request['description'],
      'mainheadercategory' => $request['mainheadercategory'],
 
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
        $user = Submheader::findOrfail($id);

$this->validate($request,[
    'submenuname'   => 'required | String |max:191',
    'mainheadercategory'   => 'required',
    'linkrouterre'   => 'required'

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

        $user = Submheader::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
