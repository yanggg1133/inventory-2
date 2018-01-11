<?php

class UserController extends \BaseController {

	protected $layout = 'template';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */ 

    public function index()
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $users = DB::select("SELECT id, first_name, last_name, email FROM users");
            $this->layout->content = View::make('users.index', array(
                'users' => $users,
                ));
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('users.create', array(
                'sellers'   => $sellers,
                ));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            try
            {
                if (Input::get('seller-account') == 0) 
                {
                    // Create the user
                    $user = Sentry::createUser(array(
                        'email'     => Input::get('email'),
                        'password'  => Input::get('password'),
                        'first_name'  => Input::get('first_name'),
                        'last_name'  => Input::get('last_name'),
                        'activated' => true,
                    ));

                    return Redirect::to('/users');
                }
                else 
                {
                    // Create the user
                    $user = Sentry::createUser(array(
                        'email'     => Input::get('email'),
                        'password'  => Input::get('password'),
                        'first_name'  => Input::get('first_name'),
                        'last_name'  => Input::get('last_name'),
                        'company'  => Input::get('seller_id'),
                        'activated' => true,
                    ));

                    return Redirect::to('/users');
                }
            }
            catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
            {
                return 'Login field is required.';
            }
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
            {
                return 'Password field is required.';
            }
            catch (Cartalyst\Sentry\Users\UserExistsException $e)
            {
                return 'User with this login already exists.';
            }
            catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
            {
                return 'Group was not found.';
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $users = DB::select("SELECT users.id as user_id, first_name, last_name, users.email as login, sellers.company as seller FROM users LEFT JOIN sellers ON (sellers.id = users.company) WHERE users.id = '$id'");
            $this->layout->content = View::make('users.show', array(
                'users' => $users,
                ));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $users = DB::select("SELECT * FROM users WHERE id = '$id'");
            $sellers = DB::select("SELECT id, company FROM sellers");
            $this->layout->content = View::make('users.edit', array(
                'users' => $users,
                'sellers'   => $sellers,
                'id'    => $id,
                ));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            try
            {
                // Find the user using the user id
                $user = Sentry::findUserById($id);

                // Update the user details
                $user->email = Input::get('email');
                $user->first_name = Input::get('first_name');
                $user->last_name = Input::get('last_name');

                // Update the user
                if ($user->save())
                {
                    
                    if (strlen(Input::get('password')) !== 0)
                    {
                        // Find the user using the user id
                        $user = Sentry::getUserProvider()->findById($id);

                        // Get the password reset code
                        $resetCode = $user->getResetPasswordCode();
                        
                        // Check if the reset password code is valid
                        if ($user->checkResetPasswordCode($resetCode))
                        {
                            // Attempt to reset the user password
                            if ($user->attemptResetPassword($resetCode, Input::get('password')))
                            {
                                echo'You\'re password has succesfully been changed';
                            }
                            else
                            {
                                echo 'There was an issue changing your password, please try again later.';
                            }
                        }
                        else
                        {
                            echo 'There was an issue changing your password, please try again later.';
                        }

                    }

                    return Redirect::to('/');
                }
                else
                {
                    // User information was not updated
                }
            }
            catch (Cartalyst\Sentry\Users\UserExistsException $e)
            {
                echo 'User with this login already exists.';
            }
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
            {
                echo 'User was not found.';
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Sentry::getUser();

        if (!Sentry::check() || $user->hasAccess('admin') != True)
        {
            return Redirect::to('/');
        }
        else
        {
            $this->layout->content = View::make('');
        }
    }

    public function settings()
    {
        $ses_user = Sentry::getUser();
            $users = DB::select("SELECT * FROM users WHERE id = '$ses_user->id'");
            $this->layout->content = View::make('users.settings', array(
                'users' => $users,
                'ses_user'  => $ses_user));

    }
}