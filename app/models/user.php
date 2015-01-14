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
            'password' => encrypt_decrypt("encrypt", $this->password),
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
        $row = $db->row($query, array($this->username, encrypt_decrypt("encrypt", $this->password)));

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

    /**
     * Fetches all registered users
     */
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
     * Deletes user account
     */
    public function deleteAccount($user_id)
    {
        $db = DB::conn();
        $db->query('DELETE FROM user WHERE id = ?', array($user_id));
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

    public function getRank()
    {
        switch ($this->rank) {
            case 1:
                return 'Power';
                break;
            case 2:
                return 'Virtue';
                break;
            case 3:
                return 'Dominion';
                break;
            case 4:
                return 'Throne';
                break;
            case 5:
                return 'Cherubim';
                break;
            default:
                return 'Rank Unknown';
        }
    }

    public function updateRank($count)
    {
        $db = DB::conn();

        if ($count >= 5 && $count < 10) {
            $db->update('user', array('rank' => 2), array('id' => $this->id)); 
        } else if ($count >= 10 && $count < 15) {
            $db->update('user', array('rank' => 3), array('id' => $this->id)); 
        } else if ($count >= 15 && $count < 20) {
            $db->update('user', array('rank' => 4), array('id' => $this->id)); 
        } else if ($count >= 20 && $count < 25) {
            $db->update('user', array('rank' => 5), array('id' => $this->id)); 
        }
    }

    public function addCommentCount()
    {
        $db = DB::conn();
        $currentCount = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $newCount = $currentCount + 1;
        $db->update('user', array('comment_count' => $newCount), array('id' => $this->id));
        $this->updateRank($newCount);
    }

    public function subtractCommentCount()
    {
        $db = DB::conn();
        $currentCount = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $newCount = $currentCount - 1;
        $db->update('user', array('comment_count' => $newCount), array('id' => $this->id));
        $this->updateRank($newCount);
    }

    public static function getTopTen()
    {
        $db = DB::conn();
        $limit = TOP_LIMIT;
        $query = "SELECT DISTINCT comment_count FROM user ORDER BY comment_count DESC LIMIT {$limit}";
        $topCommenters = $db->rows($query);
        $users = array();
        foreach ($topCommenters as $topRow) {
            $topusers = new self($topRow);
            $rows = $db->rows('SELECT * FROM user WHERE comment_count = ?', array($topusers->comment_count));
            foreach ($rows as $row) {
                $users[] = new self($row);
            }
        }
        return $users;
    }

    public function getRemainingCommentCount()
    {
        switch ($this->rank) {
            case 1:
                return 5 - $this->comment_count;
                break;
            case 2:
                return 10 - $this->comment_count;
                break;
            case 3:
                return 15 - $this->comment_count;
                break;
            case 4:
                return 20 - $this->comment_count;
                break;
            case 5:
                return 'Max Level';
                break;
            default:
                return 'Rank Unknown';
        }
    }
}