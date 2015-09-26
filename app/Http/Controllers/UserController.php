<?php

namespace ImagesManager\Http\Controllers;

use Illuminate\Http\Request;
use ImagesManager\Http\Requests;
use ImagesManager\Http\Controllers\Controller;

use ImagesManager\Http\Requests\EditProfileRequest;

// allows us to obtain the current user details in the view:
use Auth;



class UserController extends Controller
{
    // make sure the user is authenticated
    public function __construct() 
    {
    	$this->middleware('auth');
    }


    public function getEditProfile()
    {
    	return view('user.edit-profile');
    }


    public function postEditProfile(EditProfileRequest $request)
    {
    	$user = Auth::user();

        $user->name = $request->get('name');

        // check if a (new) password was entered in the profile update form
        if ($request->has('password'))
        {
            $user->password = $request->get('password');
        }

        // check if the question was changed 
        if (  $request->has('question')  &&  $request->get('question') != $user->question  )
        {
            if ( $request->has('answer') )  
            {
                $user->question = $request->get('question');
                $user->answer   = bcrypt($request->get('answer'));
            } 
            else 
            {
                return redirect('/validated/user/edit-profile')->withErrors('You must enter an answer if you change the question!');
            }
        }

        // save changes to the DB
        $user->save();

        return redirect('/home')->with(['edited' => 'Your profile was updated.']);

    }

}
