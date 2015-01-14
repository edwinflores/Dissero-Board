<?php
class ThreadController extends AppController 
{
    /** 
     * List the threads created
     */
    public function index()
    {
        $current_page = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current_page, MAX_ITEM_DISPLAY);   
        $threads = Thread::getAll();
        $other_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($other_threads);
        $page_links = createPageLinks(count($threads), $current_page, $pagination->count);
        $threads = array_slice($threads, $pagination->start_index - 1, $pagination->count);

        $this->set(get_defined_vars());
    }

    /**
     * Add new thread
     */
    public function create()
    {   
        $thread = new Thread;
        $comment = new Comment;
        $user = User::get($_SESSION['id']);
        $page = Param::get('page_next', 'create');

        switch($page)
        {
            case 'create':
                break;
            case 'create_end':
                $thread->title      = Param::get('title');
                $comment->user_id = $user->id;
                $comment->username  = $user->username;
                $comment->body      = Param::get('body');

                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
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