<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

class AlbumController extends Controller
{

    // make sure the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function getIndex()
    {
    	return 'show all user Albums....';    	
    }


    // CREATE methods
    public function getCreateAlbum()
    {
    	return 'show Create Album form....';    	
    }
    public function postCreateAlbum()
    {
    	return 'creating Album ....';    	
    }


    // EDIT methods
    public function getEditAlbum()
    {
    	return 'show Edit Album form....';    	
    }
    public function postEditAlbum()
    {
    	return 'updating Album data ....';    	
    }


    // DELETE method

    public function postDeleteAlbum()
    {
    	return 'delete Album ....';    	
    }


}
