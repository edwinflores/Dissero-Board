<?php

class UserController extends AppController
{
    const MAX_RANKING_DISPLAY = 10;

    /** 
     * Fetch values from registration page
     */
    public function register()
    {
        if(is_logged_in()) {
            redirect_to(url('thread/index'));
        }

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
        if(is_logged_in()) {
            redirect_to(url('thread/index'));
        }

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
     * Updates and/or displays user profile
     */
    public function profile()
    {
        $user = User::get($_SESSION['id']);
        $page = Param::get('page_next', 'profile');
        $nextRank = $user->getRemainingCommentCount();

        switch ($page) {
            case 'profile':
                break;
            case 'profile_update':
                $new_username = Param::get('username');
                $new_password = Param::get('password');

                try {
                    $user->updateProfile($new_username, $new_password);
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
     * Deletes user account
     */
    public function delete()
    {
        $user = User::get($_SESSION['id']);
      
        if(Param::get('delete')) {
            Comment::deleteAllByUser($user->id);       
            $user->deleteAccount($user->id);
            redirect_to(url('user/login'));
        }
    }

    /**
     * Fetch user rankings
     */
    public function ranking()
    {
        $current_page = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current_page, self::MAX_RANKING_DISPLAY);
        $users = User::getTopTen();
        $other_users = array_slice($users, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($other_users);
        $page_links = createPageLinks(count($users), $current_page, $pagination->count);
        $users = array_slice($users, $pagination->start_index -1, $pagination->count);
        
        $this->set(get_defined_vars());
    }

    /**
     * Confirms user email
     */
    public function confirmation()
    {
        $code = Param::get('passkey');
        $code = urlencode($code);
        $code = str_replace("+", "%2B", $code);
        $code = urldecode($code);
        $confirmed = User::confirmUser($code);
        $this->set(get_defined_vars());
    }

    /**
     * Removes the session
     */
    public function logout()
    {
        session_destroy();
        redirect_to(url('user/login'));
    }

    /**
     * Fetches the filtered User List
     */
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