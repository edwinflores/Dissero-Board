<?php
class CommentController extends AppController
{
    /**
     * Display thread and it's comments
     */
    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $current_page = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current_page, MAX_ITEM_DISPLAY);
        $comments = Comment::getAll($thread->id);
        $other_commments = array_slice($comments, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($other_commments);
        $page_links = createPageLinks(count($comments), $current_page, $pagination->count, 'thread_id=' . $thread->id);
        $comments = array_slice($comments, $pagination->start_index -1, $pagination->count);
        
        $this->set(get_defined_vars());
    }

    /**
     * Add new comment
     */
    public function write()
    {    
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');

        switch ($page){
            case 'write':
                break;

            case 'write_end':
                $comment->username = Param::get('username');
                $comment->body = Param::get('body');

                try {
                    $comment->write($thread->id, $comment);
                } catch (ValidationException $e) {
                    $page = 'write';
                }
                break;

            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
}