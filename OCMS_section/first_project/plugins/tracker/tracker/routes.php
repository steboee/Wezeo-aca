<?php

Route::get('api/students', function () {
    return \Tracker\Tracker\Models\Student::all();
});

Route::get('api/arrivals', function () {
    return \Tracker\Tracker\Models\Arrival::all();
});

Route::get("api/my-arrivals", function () {
    $user = Auth::getUser();
    $student = \Tracker\Tracker\Models\Student::where('user_id', $user->id)->first();
    $arrivals = \Tracker\Tracker\Models\Arrival::where('student_id', $student->id)->get();
    return $arrivals;
});

Route::post('api/log_user', function () {
    $user = Auth::getUser();
    $student = \Tracker\Tracker\Models\Student::where('user_id', $user->id)->first();
    $arrival = new \Tracker\Tracker\Models\Arrival;
    

    $student_name = request('name');
    $arrival_date = date('Y-m-d H:i:s');
    $delayed = $arrival_date > '08:00:00' ? true : false;

    $student = new \Tracker\Tracker\Models\Student;
    $student->name = $student_name;
    $student->save();

    $arrival = new \Tracker\Tracker\Models\Arrival;
    $arrival->student_id = $student->id;
    $arrival->arrival_date = $arrival_date;
    $arrival->delayed = $delayed;
    $arrival->save();

    return $arrival;
});
