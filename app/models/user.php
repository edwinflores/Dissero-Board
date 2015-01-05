<?php

class User extends AppModel
{
    private $is_login_valid = true;

    public $validation = array(

            'username' => array(
                'duplicate' => array('isRegistered'
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
    );

    private function getRowByUsername()
    {
        $db = DB::conn();
        $query = "SELECT id FROM user WHERE BINARY username = ?";
        $row = $db->row($query, array($this->username));

        return $row;
    }

    //Check if the username is already registered
    public function isRegistered()
    {
        $row = self::getRowByUsername();
        return(empty($row));
    }

    //Adds a user
    public function register()
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid username or password input');
        }

        $input = array(
            'username' => $this->username,
            'password' => $this->password
        );

        $row = self::getRowByUsername();
        if ($row) {
            throw new ValidationException('Username is already registered, use another.');
        }

        $db->insert('user', $input);
    }

    //Verifies login credentials
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

    //Called to check if the login is valid or not
    public function isLoginValid()
    {
        return $this->is_login_valid;
    }
}