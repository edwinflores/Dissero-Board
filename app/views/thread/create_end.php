<h2><?php encode_string($thread->title)?></h2>

<p class="alert alert-success">
    You successfully created a thread.
</p>

<a href="<?php encode_string(url('comment/view', array('thread_id' => $thread->id)))?>">
    &larr; Go to thread.
</a>

