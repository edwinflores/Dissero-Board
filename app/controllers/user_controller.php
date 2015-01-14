<?php

class UserController extends AppController
{
    /** 
     * Fetch values from registration page
     */
    public function register()
    {
        $user = new User;
        $page = Param::get('page_next', 'register');

        switch ($page) {
            case 'register':
                break;

            case 'register_end':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->email = Param::get('email');

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

    /**
     * Verify values from login page
     */
    public function login()
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

    /**
     * Updates user profile
     */
    public function profile()
    {
        $user = User::get($_SESSION['id']);
        $page = Param::get('page_next', 'profile');

        switch ($page) {
            case 'profile':
                break;
            case 'profile_end':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->email = Param::get('email');

                try {
                    $user->updateProfile();
                } catch (ValidationException $e) {
                    $page = 'profile';
                }
                break;
            default:
                throw new PageNotFoundException('{$page} not found');
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
     * Deletes user profile
     */
    public function delete()
    {
        $user = User::get($_SESSION['id']);
      
        if(Param::get('delete')) {
            $user->deleteAccount($user->id);
        }

        redirect_to(url('user/login'));
    }

    /**
     * Removes the session
     */
    public function logout()
    {
        session_destroy();
        redirect_to(url('user/login'));
    }

    public function userlist()
    {
        $filter = Param::get('filter');

        $current_page = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current_page, MAX_ITEM_DISPLAY);
        $users = User::filter($filter);
        $other_users = array_slice($users, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($other_users);
        $page_links = createPageLinks(count($users), $current_page, $pagination->count);
        $users = array_slice($users, $pagination->start_index -1, $pagination->count);
        
        $this->set(get_defined_vars());
    }
}