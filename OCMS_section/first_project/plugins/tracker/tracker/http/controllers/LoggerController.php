<?php

namespace Ctibor\Tracker\Http\Controllers;

use Ctibor\tracker\Models\Arrival;
use Illuminate\Routing\Controller;
use Event;


class UserController extends Controller
{

    public function index()
    {
        
    }

    public function store($request) 
    {
        $arrival = new Arrival;
        $arrival->arrival_date = $request->arrival_date;
    }

}