<?php

namespace ImagesManager\Http\Controllers\Auth;

use ImagesManager\User;
use Validator;
use ImagesManager\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use ImagesManager\Http\Requests\PasswordRecoveryRequest;

use Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|max:255|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'question' => 'required|max:255',
            'answer'   => 'required|max:255|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     =>        $data['name'],
            'email'    =>        $data['email'],
            'password' => bcrypt($data['password']),
            'question' =>        $data['question'],
            'answer'   => bcrypt($data['answer']),
        ]);
    }



    public function getRecoverPassword()
    {
        return view('auth.recover');
    }

    public function postRecoverPassword(PasswordRecoveryRequest $request)
    {
        $question = $request->get('question');
        $answer   = $request->get('answer');

        $user = User::where('email', $request->get('email'))->first();

        // compare question and answer
        // (answer is encrypted in the database, so we need to encrypt the given answer as well)
        if ( $user->question === $question  &&  Hash::check($answer, $user->answer) ) 
        {
            $user->password = bcrypt($request->get('password'));
            $user->save();
            return redirect('auth/login')
                ->with(['success' => 'The password was changed.']);
        }

        return redirect('auth/recover-password')
            ->withInput($request->only('email', 'question'))
                ->withErrors('The answer to the question was incorrect.');
    }

}
