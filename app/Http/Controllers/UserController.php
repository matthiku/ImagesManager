<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

class UserController extends Controller
{
    // make sure the user is authenticated
    public function __construct() 
    {
    	$this->middleware('auth');
    }


    public function getEditProfile()
    {
    	return 'Showing the Edit Profile form';
    }


    public function postEditProfile()
    {
    	return 'Showing the Change Profile form....';
    }

}
