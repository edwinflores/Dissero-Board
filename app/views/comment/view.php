<h2><font style="font-size: 45px"><?php encode_string($thread->title) ?></font>
<div align="left"><a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a></div>
</h2>
<hr width="90%" align="center" size="8" noshade>
<?php foreach ($comments as $key => $value): ?>
    <div class="comment">

        <div class="meta">
            <font style="font-size: 18px"><?php encode_string($key + 1) ?>: 
            <font style="font-size: 20px"><u><?php encode_string($value->username) ?></u><br /> 
            <font style="font-size: 18px"><strong>Rank : </strong><i><?php encode_string(User::get($value->user_id)->getRank()) ?></i><br />
            <font style="font-size: 15px"><strong>Posted : </strong><?php encode_string(time_ago($value->created)) ?>
            </font>
        </div>

        <div>
            <font style="font-size: 18px">
            <?php echo "> " . readable_text($value->body); ?>
            </font>
        </div>
        <br>
        <?php if($_SESSION['id'] === $value->user_id): ?>
            <a class="btn btn-info btn-sm" href="<?php encode_string(url('comment/edit', array('thread_id' => $thread->id, 'comment_id' => $value->id))) ?>">Edit</a>
            <a class="btn btn-danger btn-sm" href="<?php encode_string(url('comment/delete', array('thread_id' => $thread->id, 'comment_id' => $value->id))) ?>">Delete</a>
        <?php endif ?>
    </div>
    <hr width="90%" align="center" size="4" noshade>
<?php endforeach ?>

<div class="pagination">    
    <?php if($pagination->current > 1): ?>
        <a class='btn btn-primary btn-sm' href='?page=<?php encode_string($pagination->prev) ?>&thread_id=<?php encode_string($thread->id)?>'>Previous</a>
    <?php endif ?>

    <?php echo $page_links ?>


    <?php if(!$pagination->is_last_page): ?>
        <a class='btn btn-primary btn-sm' href='?page=<?php encode_string($pagination->next)?>&thread_id=<?php encode_string($thread->id)?>'>Next</a>
    <?php endif ?>
</div>

<hr>
<form class="well" method="post" action="<?php encode_string(url('comment/write'))?>">
    <label>Comment:</label>
    <textarea style="width:40%" rows=6 name="body"><?php encode_string(Param::get('body')) ?></textarea>
    </br>
    <input type="hidden" name="thread_id" value="<?php encode_string($thread->id)?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>    
</form>
<a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>
