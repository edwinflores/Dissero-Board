<?php

class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', MIN_TITLE_CHARACTERS, MAX_TITLE_CHARACTERS,
            ),
        ),
    );

    public static function get($id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if(!$row)
        {
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    public static function getAll(){
        $threads = array();

        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM thread');

        foreach ($rows as $row){
            $threads[] = new Thread($row);
        }

        return $threads;
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();

        if($this->hasError() || $comment->hasError())
        {
            throw new ValidationException('invalid thread or comment');
        }

        $db = DB::conn();
        $db->begin();

        $db->query('INSERT INTO thread SET title = ?, created=NOW()', array($this->title));

        $this->id = $db->lastInsertId();
        $comment->write($this->id, $comment);

        $db->commit();
    }
}