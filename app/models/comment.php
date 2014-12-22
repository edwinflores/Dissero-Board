<?php
    class Comment extends AppModel
    {
        public $validation = array(

            'username' => array(
                'length' => array(
                    'validate_between', 1, 16,
                ),
            ),

            'body' => array(
                'length' => array(
                    'validate_between', 1, 200,
                ),
            ),
        );

        // Fetches all comments from Database
        public static function getAll($thread_id)
        {
            $comments = array();

            $db = DB::conn();

            $rows = $db->rows(
                'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC', array($thread_id));

            foreach ($rows as $row){
                $comments[] = new Comment($row);
            }

            return $comments;
        }

        // Inserts a new comment to the database
        public function write($thread_id, Comment $comment)
        {
            if(!$this->validate()) {
                throw new ValidationException('Invalid comment.');
            }

            $db = DB::conn();
            
            $db->query(
                'INSERT INTO comment SET thread_id=?, username=?, body=?, created=NOW()', array($thread_id, $comment->username, $comment->body)
            );
        }
    }
?>