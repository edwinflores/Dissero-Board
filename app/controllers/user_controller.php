<?php

class UserController extends AppController
{
    //Fetch values from registration page
    public function register ()
    {
        $user = new User;
        $page = Param::get('page_next', 'register');

        switch ($page) {
            case 'register':
                break;

            case 'register_end':
                $user->username = Param::get('username');
                $user->password = Param::get('password');

                try {
                    $user->register();
                } catch (ValidationException $e) {
                    $page = 'register';
                }
                break;

            default:
                throw new PageNotFoundExcpetion("{$page} not found");
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    // Verify values from login page
    public function login ()
    {
        $user = new User;
        $page = Param::get('page_next', 'login');

        switch($page) {
            case 'login':
                break;

            case 'lobby':
                $user->username = Param::get('username');
                $user->password = Param::get('password');

                try {
                    $userAccount = $user->verify();

                    $_SESSION['id'] = $userAccount['id'];
                    $_SESSION['username'] = $userAccount['username'];
                } catch (UserNotFoundException $e) {
                    $page = 'login';
                }
                break;

            default:
                throw new UserNotFoundException("User not found");
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    //Removes the session
    public function logout ()
    {
        session_destroy();
        redirectTo(url('user/login'));
    }
}