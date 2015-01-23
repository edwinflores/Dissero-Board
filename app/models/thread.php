<?php
class Thread extends AppModel
{
    const MIN_TITLE_CHARACTERS = 1;
    const MAX_TITLE_CHARACTERS = 30;

    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', self::MIN_TITLE_CHARACTERS, self::MAX_TITLE_CHARACTERS,
            ),
        ),
    );

    /**
     * Fetch a thread given an id
     */
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    /**
     * Fetches all threads
     */
    public static function getAll()
    {
        $threads = array();
        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM thread ORDER BY created DESC');

        foreach ($rows as $row){
            $threads[] = new self($row);
        }

        return $threads;
    }

    /**
     * Insert a new thread with it's first comment to the database
     */
    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }

        try {
            $db = DB::conn();
            $db->begin();
            $db->insert('thread', array('title' => $this->title));
            $this->id = $db->lastInsertId();
            $comment->thread_id = $this->id;
            $comment->write($comment);
            $db->commit();
        } catch (RecordNotFoundException $e) {
            $db->rollback();
        }
    }
}