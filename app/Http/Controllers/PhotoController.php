<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

class photoController extends Controller
{

    // make sure the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }



    // show ALL albums of this user
    public function getIndex()
    {
    	return 'show all Photos of selected album ....';    	
    }


    // CREATE methods
    public function getCreatePhoto()
    {
    	return 'show Create Photo form....';    	
    }
    public function postCreatePhoto()
    {
    	return 'creating Photo entyry ....';    	
    }


    // EDIT methods
    public function getEditPhoto()
    {
    	return 'show Edit Photo form....';    	
    }
    public function postEditPhoto()
    {
    	return 'updating Photo data ....';    	
    }


    // DELETE method

    public function postDeletePhoto()
    {
    	return 'delete Photo ....';    	
    }

}
