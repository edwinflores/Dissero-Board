<?php

class User extends AppModel
{
    //Ranking related
    const RANKUP_MULTIPLIER = 5;
    const MAX_RANK = 5;
    const MIN_RANK = 1;

    //Top Ten related
    const TOP_LIMIT = 10;

    private $is_login_valid = true;

    private static $rank_equivalent = array(
                                '1' => 'Power',
                                '2' => 'Virtue',
                                '3' => 'Dominion',
                                '4' => 'Throne',
                                '5' => 'Cherubim');

    public $validation = array(
            'username' => array(
                'duplicate' => array('isUsernameRegistered'
                ),
                'format' => array('is_valid_format'
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

        $confirm_code = encrypt_decrypt("encrypt", $this->email);

        $input = array(
            'username' => $this->username,
            'password' => encrypt_decrypt("encrypt", $this->password),
            'email' => $this->email,
            'confirm_code' => $confirm_code
        );

        $db = DB::conn();
        $db->insert('user', $input);
        sendConfirmCode($confirm_code, $this->email);
    }

    /**
     * Update the user's profile
     */
    public function updateProfile($new_username, $new_password)
    {
        $input = array();

        if (!is_valid_username($new_username) || !is_valid_password($new_password)) {
            throw new ValidationException('Invalid username or password input');
        }

        if ($new_username != $this->username) {
            $this->username = $new_username;
            $input['username'] = $this->username;
        }

        if ($new_password != encrypt_decrypt("decrypt", $this->password)) {
            $this->password = $new_password;
            $input['password'] = encrypt_decrypt("encrypt", $this->password);
        }

        if (!empty($input))
        {
            $db = DB::conn();
            $db->update('user', $input, array('id' => $this->id));
        }
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
     * Called to check if the login is valid or not
     */
    public function isLoginValid()
    {
        return $this->is_login_valid;
    }

    /**
     * Gets the user's rank and converts it to it's string value
     */
    public function getRank()
    {
        return self::$rank_equivalent[$this->rank];
    }

    /**
     * Checks if the user's rank needs to be increased or decreased
     */
    public function updateRank()
    {
        $db = DB::conn();

        $comment_requirement = $this->rank * self::RANKUP_MULTIPLIER;
        $previous_rank_requirement = ($this->rank-1) * self::RANKUP_MULTIPLIER;
        $new_rank = $this->rank;
        if ($this->getCommentCount() >= $comment_requirement && $this->rank < self::MAX_RANK) {
            $new_rank = ++$new_rank;
        } 

        if ($this->getCommentCount() <= $previous_rank_requirement && $this->rank > self::MIN_RANK) {
            $new_rank = --$new_rank;
        }

        $db->update('user', array('rank' => $new_rank), array('id' => $this->id));
    }

    /**
     * Increments the user's comment count
     */
    public function addCommentCount()
    {
        $db = DB::conn();
        $current_count = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $new_count = ++$current_count;
        $db->update('user', array('comment_count' => $new_count), array('id' => $this->id));
        $this->updateRank($new_count);
    }

    /**
     * Decrements the user's comment count
     */
    public function subtractCommentCount()
    {
        $db = DB::conn();
        $current_count = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $new_count = --$current_count;
        $db->update('user', array('comment_count' => $new_count), array('id' => $this->id));
        $this->updateRank($new_count);
    }

    /**
     * Fetches the top users with the highest comment counts
     */
    public static function getTopTen()
    {
        /*$db = DB::conn();
        $query = "SELECT DISTINCT comment_count FROM user ORDER BY comment_count DESC LIMIT " . self::TOP_LIMIT;
        $top_commenters = $db->rows($query);
        $users = array();
        foreach ($top_commenters as $top_row) {
            $top_users = new self($top_row);
            $rows = $db->rows('SELECT * FROM user WHERE comment_count = ?', array($top_users->comment_count));
            foreach ($rows as $row) {
                $users[] = new self($row);
            }
        }
        return $users;*/

        //$thread_rows = $db->rows("SELECT $comment_counts as comment_count FROM thread
        //    order by comment_count ORDERY BY comment_count DESC LIMIT 10;")

        $db = DB::conn();
        $query = "SELECT DISTINCT $comment_counts as comment_count FROM user ORDER BY comment_count DESC LIMIT " . self::TOP_LIMIT;
        $top_commenters = $db->rows($query);
        $users = array();
        foreach ($top_commenters as $top_row) {
            $top_users = new self($top_row);
            $rows = $db->rows('SELECT * FROM user');
        }
    }

    /**
     * Computes the remaining number of comments a user needs to rank up
     */
    public function getRemainingCommentCount()
    {
        if ($this->rank < self::MAX_RANK) {
            return ($this->rank * self::RANKUP_MULTIPLIER) - $this->getCommentCount();
        } else {
            return 'Max Rank';    
        }
    }
     
    /**
     * Fetches a filtered list of users based on rank
     */   
    public static function filter($filter)
    {
        $rank = array_search($filter, self::$rank_equivalent);

        $db = DB::conn();

        if($rank) {
            $rows = $db->rows('SELECT * FROM user WHERE rank = ? ORDER BY comment_count DESC', array($rank));

            $users = array();
            foreach ($rows as $row) {
                $users[] = new self($row);
            }
            return $users;
        } else {
            return self::getAll();
        }
    }

    /**
     * Checks the DB for valid code and confirms the user's email
     */
    public static function confirmUser($confirm_code)
    {
        $db = DB::conn();
        $code = strval($confirm_code);
        $row = $db->row("SELECT * FROM user WHERE confirm_code = ?", array($code));

        if($row) {
            $db->update('user', array('verified' => 1), array('confirm_code' => $code));
            return true;
        }
        return false;
    }

    public function getCommentCount()
    {
        $db = DB::conn();
        $comment_count = count($db->rows('SELECT id FROM comment WHERE user_id = ?', array($this->id)));
        return $comment_count;
    }
}