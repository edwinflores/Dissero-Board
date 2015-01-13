<h2><?php encode_string($thread->title) ?></h2>

<?php if($comment->hasError()): ?>
<div class="alert alert-block">

    <h4 class="alert-heading">Validation error!</h4>

    <?php if (!empty($comment->validation_errors['body']['length'])): ?>
        <div><em>Comment</em> must be
        between <?php encode_string($comment->validation['body']['length'][1])?>
        and
        <?php encode_string($comment->validation['body']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>

</div>
<?php endif ?>

<form class="well" method="post" action="<?php encode_string(url('thread/write')) ?>">
    <label>Comment</label>
    <textarea name="body"><?php encode_string(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php encode_string($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>