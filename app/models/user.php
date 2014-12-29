<?php

class User extends AppModel
{
    private $is_login_valid = true;

    const MIN_NAME_CHARACTERS = 3;
    const MAX_NAME_CHARACTERS = 20;

    const MIN_PASSWORD_CHARACTERS = 8;
    const MAX_PASSWORD_CHARACTERS = 20;

    public $validation = array(

            'username' => array(
                'duplicate' => array('checkDuplicates'
                ),
                'length' => array(
                    'validate_between', self::MIN_NAME_CHARACTERS, self::MAX_NAME_CHARACTERS,
                ),
            ),

            'password' => array(
                'length' => array(
                    'validate_between', self::MIN_PASSWORD_CHARACTERS, self::MAX_PASSWORD_CHARACTERS,
                ),
            ),
    );

    //Check if the username is already registered
    public function checkDuplicates($username)
    {
        $db = DB::conn();
        $query = "SELECT id FROM user WHERE BINARY username = ?";
        $row = $db->row($query, array($this->username));

        if($row) {
            return false;
        } else{
            return true;
        }
    }

    //Adds a user
    public function register()
    {
        
        if (!$this->validate())
        {
            throw new ValidationException('Invalid username or password input');
        }

        $input = array(
            'username' => $this->username,
            'password' => $this->password
        );

        
        $db = DB::conn();
        $query = "SELECT id FROM user WHERE username = ?";
        $row = $db->row($query, array($this->username));

        if($row)
        {
            throw new ValidationException('Username is already registered, use another.');
        }


        $db->insert('user', $input);
    }

    //Verifies login credentials
    public function verify()
    {
        $query = "SELECT id, username FROM user WHERE BINARY username = ? AND BINARY password = ?";

        $db = DB::conn();
        $row = $db->row($query, array($this->username, $this->password));

        if(!$row)
        {
            $this->is_login_valid = false;
            throw new UserNotFoundException('Wrong username or password. Please try again');
        }

        return $row;
    }

    //Called to check if the login is valid or not
    public function isLoginValid()
    {
        return $this->is_login_valid;
    }
}