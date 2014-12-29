<h1><?php encodeString($thread->title) ?></h1>

<?php foreach ($comments as $key => $value): ?>
    <div class="comment">

        <div class="meta">
            <font style="font-size: 20px">
            <?php encodeString($key + 1) ?>: <?php encodeString($value->username) ?><br /> 
            <font style="font-size: 15px"> Posted : <?php encodeString($value->created) ?>
            </font>
        </div>

        <div>
            <font style="font-size: 15px">
            <?php echo readable_text($value->body) ?>
            </font>
        </div>
        <br />

    </div>
<?php endforeach ?>

<div class="pagination">
    <?php if($pagination->current > 1): ?>
        <a class='btn btn-small' href='?page=<?php encodeString($pagination->prev) ?>&thread_id=<?php encodeString($thread->id)?>'>Previous</a>
    <?php endif ?>

    <?php echo $page_links ?>

    <?php if(!$pagination->is_last_page): ?>
        <a class='btn btn-small' href='?page=<?php encodeString($pagination->next)?>&thread_id=<?php encodeString($thread->id)?>'>Next</a>
    <?php endif ?>
</div>

<hr>

<form class="well" method="post" action="<?php encodeString(url('comment/write'))?>">
    <label>Your name:</label>
    <input type="text" class="span2" name="username" value="<?php encodeString(Param::get('username')) ?>">
    <label>Comment:</label>
    <textarea name="body"><?php encodeString(Param::get('body')) ?></textarea>
    </br>
    <input type="hidden" name="thread_id" value="<?php encodeString($thread->id)?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
    
</form>

<br />
<a class="btn btn-danger" href="<?php encodeString(url('thread/index')) ?>">Back to Index</a>
