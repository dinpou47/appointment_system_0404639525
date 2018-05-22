<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        $clients = Client::where('userID', $id)->get();

        if ($clients->isEmpty())
            return view('home');

        else {
            return view('client.client_dashboard', compact('clients'))->with('title', "Your Details"
            );

        }

    }
}
