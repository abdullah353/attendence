<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
  $employees = App\Employee::with(array('checkins'=>function($query){
    $query->where('day', '=', "2015-10-10");}))
    ->get()
    ->toJSON();
 // echo $employee;
  //echo Carbon\Carbon::now()->toDateString();
  return view('welcome')->with('employees', $employees);
});


Route::get('/update', function () {

  // create curl resource 
  $ch = curl_init(); 
  $url = "http://192.168.0.3/form/Download";
  $fields_string = "";
  $fields = array(
    "period" => 1,
    "edate" => "2015-11-08",
    "sdate" => "2015-10-08",
    "Download" => "Download"
  );

  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }

  for($i=1; $i <= 100; $i++) {
    $fields_string .= 'uid='.$i.'&';
  } 

  $fields_string = rtrim($fields_string, '&');

  // set url 
  curl_setopt($ch, CURLOPT_URL, $url); 

  //return the transfer as a string 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  // $output contains the output string 
  $output = curl_exec($ch); 
  $output = preg_split('/\s\s/', $output);
  
  foreach($output as $event) {
    $event = preg_split('/\s+/', $event);
    if(count($event) == 6) {
      $deviceId = $event[0];
      $name = $event[1];
      $date = $event[2];
      $time = $event[3];
      $start = $event[4];
      $end = $event[5];
       
      $employee = App\Employee::firstOrCreate(array(
        'name' => $name,
        'device_id' => $deviceId
      ));

      $checkin = App\Checkin::firstOrCreate(array(
        'day' => $date,
        'checkin' => $time,
        'start' => $start,
        'end' => $end,
        'employee_id' => $employee->id
      ));
      
    }
  }

  // close curl resource to free up system resources 
  curl_close($ch);
});
