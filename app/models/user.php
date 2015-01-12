<?php

class User extends AppModel
{
    private $is_login_valid = true;

    public $validation = array(
            'username' => array(
                'duplicate' => array('isUsernameRegistered'
                ),
                'length' => array(
                    'validate_between', MIN_USERNAME_CHARACTERS, MAX_USERNAME_CHARACTERS,
                ),
            ),

            'password' => array(
                'length' => array(
                    'validate_between', MIN_PASSWORD_CHARACTERS, MAX_PASSWORD_CHARACTERS,
                ),
            ),

            'email' => array(
                'duplicate' => array('isEmailRegistered'
                ),
            ), 
    );

    /**
     * Check if the username is already registered
     */
    public function isUsernameRegistered()
    {
        $db = DB::conn();
        $query = "SELECT id FROM user WHERE BINARY username = ?";
        $row = $db->row($query, array($this->username));

        return(empty($row));
    }

    /**
     * Check if the email address is already registered
     */
    public function isEmailRegistered()
    {
        $db = DB::conn();
        $query = "SELECT email FROM user WHERE BINARY email = ?";
        $row = $db->row($query, array($this->email));

        return(empty($row));
    }

    /**
     * Adds a user
     */
    public function register()
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid username or password input');
        }

        if (!$this->isUsernameRegistered()) {
            throw new ValidationException('Username is already registered, use another.');
        }

        if (!$this->isEmailRegistered()) {
            throw new ValidationException('Email is already registered, use another.');
        }

        $input = array(
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email
        );

        $db = DB::conn();
        $db->insert('user', $input);
    }

    /**
     * Verifies login credentials
     */
    public function verify()
    {
        $db = DB::conn();
        $query = "SELECT id, username FROM user WHERE BINARY username = ? AND BINARY password = ?";
        $row = $db->row($query, array($this->username, $this->password));

        if (!$row) {
            $this->is_login_valid = false;
            throw new UserNotFoundException('Wrong username or password. Please try again');
        }

        return $row;
    }

    /**
     * Fetches a user's data
     */
    public static function get($user_id)
    {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM user WHERE id = ?", array($user_id));

        if(!$row) {
            throw new UserNotFoundException('User not found.');
        }

        return new self($row);
    }

    public static function getAll()
    {
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM user ORDER BY created DESC');

        $users = array();
        foreach ($rows as $row) {
            $users[] = new self($row);
        }
        return $users;
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        
    }

    /** 
     * Called to check if the login is valid or not
     */
    public function isLoginValid()
    {
        return $this->is_login_valid;
    }
}