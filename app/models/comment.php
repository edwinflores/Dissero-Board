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

      public static function get($comment_id)
      {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM comment WHERE id = ?", array($comment_id));

        if(!$row) {
            throw new RecordNotFoundException('Comment Not Found');
        }

        return new self($row);
      }

      /**
       * Fetches all comments from Database
       */
      public static function getAll($thread_id)
      {
         $db = DB::conn();
         $rows = $db->search('comment', 'thread_id = ?', array($thread_id), 'created DESC');
         $comments = array();
         foreach ($rows as $row){
            $comments[] = new self($row);
         }

         return $comments;
      }

      /**
       * Inserts a new comment to the database
       */
      public function write(Comment $comment)
      {
         if (!$this->validate()) {
            throw new ValidationException('Invalid comment.');
         }

         $db = DB::conn();
         $params = array(
            'thread_id' => $comment->thread_id,
            'user_id' => $comment->user_id,
            'username' => $comment->username,
            'body' => $comment->body
         );

         $db->insert('comment', $params);
      }

      /**
     * Deletes a comment
     */
    public function deleteComment($comment)
    {
        $db = DB::conn();
        $db->query('DELETE FROM comment WHERE id = ?', array($comment->id));

        $user = User::get($comment->user_id);
        $user->subtractCommentCount();
    }
   }
?>