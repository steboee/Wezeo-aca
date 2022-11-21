<?php

namespace Ctibor\Tracker\Http\Controllers;

use Ctibor\tracker\Models\Arrival;
use Illuminate\Routing\Controller;
use Event;


class UserController extends Controller
{

    public function index()
    {

        Event::fire('adrian.arrivallogger.requestArrivals');

        $authId = Auth::user()->id;
        return Arrivallogger::where('user_id', '=', $authId)->get();
    }

    public function store($request) 
    {
        $arrival = new Arrival;
        $arrival->arrival_date = $request->arrival_date;


    }

}