<?php
    class Comment extends AppModel
    {
        public $validation = array(

            'username' => array(
                'length' => array(
                    'validate_between', MIN_USERNAME_CHARACTERS, MAX_USERNAME_CHARACTERS,
                ),
            ),

            'body' => array(
                'length' => array(
                    'validate_between', MIN_BODY_CHARACTERS, MAX_BODY_CHARACTERS,
                ),
            ),
        );

        // Fetches all comments from Database
        public static function getAll($thread_id)
        {
            $db = DB::conn();
            $rows = $db->rows(
                'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($thread_id));

            $comments = array();
            foreach ($rows as $row){
                $comments[] = new Comment($row);
            }

            return $comments;
        }

        // Inserts a new comment to the database
        public function write($thread_id, Comment $comment)
        {
            if (!$this->validate()) {
                throw new ValidationException('Invalid comment.');
            }

            $db = DB::conn();
            $params = array(
                'title' => $this->title,
                'created' => NOW()
            );
            $db->insert('thread', $params);
        }
    }
?>