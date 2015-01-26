<?php
class Comment extends AppModel
{
    const MIN_BODY_CHARACTERS = 1;
    const MAX_BODY_CHARACTERS = 200;

    public $validation = array(
        'body' => array(
            'length' => array(
                'validate_between', self::MIN_BODY_CHARACTERS, self::MAX_BODY_CHARACTERS,
            ),
            'format' => array('check_whitespace'
            ),
        ),
    );

    /**
     * Fetches a specific comment
     */
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
            'body' => $comment->body
        );

        $db->insert('comment', $params);
    }

    /**
     * Deletes a comment
     */
    public function delete($comment)
    {
        $db = DB::conn();
        $db->query('DELETE FROM comment WHERE id = ?', array($comment->id));
    }

    /**
     * Deletes all comments created bu a certain user
     */ 
    public function deleteAllByUser($user_id)
    {
        $db = DB::conn();
        $db->query('DELETE FROM comment WHERE user_id = ?', array($user_id));
    }

    /**
     * Edits a particular comment
     */
    public function edit()
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid Comment');
        }

        $db = DB::conn();
        $db->update('comment', array('body' => $this->body), array('id' => $this->id));
    }
}
