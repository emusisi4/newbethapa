<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Studentclasses;
//use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       // return Student::all();
     return   Student::with(['studentClass','studentSection'])->latest('id')
     ->where('del', 0)
     ->get();

     

   ///  return $this->hasMany('App\Studentclasses');

 //   return $classname = Student::with('studentclass')->get();
    // $users = DB::table('students')
    // ->join('nur_classes', 'students.studentclass', '=', 'nur_classes.classno')
   //  ->join('orders', 'users.id', '=', 'orders.user_id')
     //->select('students.*', 'nur_classes.classno')
     //->get();











      // return Student::all()->sortByDesc("id");
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
      //  return ['message' => 'I have your data'];
    //  return $request->all();
 //  return ['message' => 'I have your data'];
    //  return $request->all();
    //return $request->all();
/// setting the Validaation Rules
$this->validate($request,[
    'firstname'   => 'required | String |max:191',
 //   'middlename'   => 'required | String |max:191',
    'lastname'   => 'required | String |max:191',
 //   'feespaymentno'   => 'required | String | pno |max:191|unique:students',
    'feespaymentno'   => 'required',
  
    'primarycontact'   => 'required | String |max:191',
    'primarycontactperson'   => 'required | String |max:191',
  
    'gender'   => 'required | String |min:1'
    
    ]);
    $id1  = Student::latest('id')->where('del', 0)->value('studentno');
    $id = $id1+1;
    $datale = strlen($id);
    if($datale > 2)
    {
        $dats = $id;
    }
    if($datale == 2)
    {
        $dats = '0'.$id;
    }
    if($datale < 2)
    {
        $dats = '00'.$id;
    }
/// saving the users Data

return Student::Create([
    'firstname' => $request['firstname'],
    'primarycontact' => $request['primarycontact'],
    'primarycontactname' => $request['primarycontactperson'],
    'middlename' => $request['middlename'],
    'lastname' => $request['lastname'],
    'fathername' => $request['fathername'],
    'fathercontact' => $request['fatherscontact'],
    'dob' => $request['dob'],
    'pno' => $request['feespaymentno'],
    'studentno' => $dats,
    'entrydate' => $request['doe'],
    'nok' => $request['nok'],
    'nokcontact' => $request['nokcontact'],
    'foccupation' => $request['fathersoccupation'],
    'mothersname' => $request['mothersname'],
    'moccupation' => $request['mothersoccupation'],
    'studentclass' => $request['studentclassenrolled'],
    'healthdescription' => $request['healthdescrition'],
    'formerschool' => $request['formerschool'],
    'anycoronicaldisease' => $request['deasesatatus'],
    'mcontact' => $request['motherscontact'],
    'ssection' => $request['ssection'],
    'gender' => $request['gender'],
    'residence' => ($request['residence']),
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
$user = Student::findOrfail($id);

$this->validate($request,[
    'firstname'   => 'required | String |max:191',
    'firstname'   => 'required | String |max:191',
    'studentno'   => 'required | String |min:3|unique:students,email,'.$user->id,
    'lastname'   => 'required |min:2'
    
    ]);


$user->update($request->all());
      //  return ['message', 'Data updated'];
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
        $user = Student::findOrFail($id);
        //// Delete the User

$user->delete();
        //// Redirecting back 
        return ['message' => 'User DEleted'];
    }
}
