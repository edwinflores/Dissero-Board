<?php

class User extends AppModel
{
    const RANKUP_MULTIPLIER = 5;
    const MAX_RANK = 5;
    const MIN_RANK = 1;

    private $is_login_valid = true;

    private static $rankEquivalent = array(
                                '1' => 'Power',
                                '2' => 'Virtue',
                                '3' => 'Dominion',
                                '4' => 'Throne',
                                '5' => 'Cherubim');

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
        return self::$rankEquivalent[$this->rank];
    }

    /**
     * Checks if the user's rank needs to be increased or decreased
     */
    public function updateRank($count)
    {
        $db = DB::conn();

        $numRequired = $this->rank * self::RANKUP_MULTIPLIER;
        $previousRankReq = ($this->rank-1) * self::RANKUP_MULTIPLIER;

        if ($count >= $numRequired && $this->rank < self::MAX_RANK) {
            $newRank = ++$this->rank;
            $db->update('user', array('rank' => $newRank), array('id' => $this->id));
        }

        if ($count <= $previousRankReq && $this->rank > self::MIN_RANK) {
            $newRank = --$this->rank;
            $db->update('user', array('rank' => $newRank), array('id' => $this->id));            
        }
    }

    /**
     * Increments the user's comment count
     */
    public function addCommentCount()
    {
        $db = DB::conn();
        $currentCount = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $newCount = ++$currentCount;
        $db->update('user', array('comment_count' => $newCount), array('id' => $this->id));
        $this->updateRank($newCount);
    }

    /**
     * Decrements the user's comment count
     */
    public function subtractCommentCount()
    {
        $db = DB::conn();
        $currentCount = $db->value('SELECT comment_count FROM user WHERE id = ?', array($this->id));
        $newCount = --$currentCount;
        $db->update('user', array('comment_count' => $newCount), array('id' => $this->id));
        $this->updateRank($newCount);
    }

    /**
     * Fetches the top users with the highest comment counts
     */
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

    /**
     * Computes the remaining number of comments a user needs to rank up
     */
    public function getRemainingCommentCount()
    {
        if ($this->rank < self::MAX_RANK) {
            return ($this->rank * self::RANKUP_MULTIPLIER) - $this->comment_count;
        } else {
            return 'Max Rank';    
        }
    }
     
    /**
     * Fetches a filtered list of users based on rank
     */   
    public static function filter($filter)
    {
        $rank = array_search($filter, self::$rankEquivalent);

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
}