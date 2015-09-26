<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

class HomeController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        //
        return view('home');
    }

}
