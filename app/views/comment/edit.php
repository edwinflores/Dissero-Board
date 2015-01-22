<h2><?php encode_string($thread->title) ?></h2>
<div>
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
</div>

<form class="well" method="POST">
    <label><font style="font-size: 20px">Edit Comment:</font></label>
    <br>
    <textarea name="body" style="width:30%" rows=6 required><?php encode_string($comment->body) ?></textarea>
    <br>
    <button type="submit" name="edit" value="save" class="btn btn-info">Save Changes</button>
    <br><br>
    <a class="btn btn-primary" href="<?php encode_string(url('comment/view', array('thread_id' => $thread->id)))?>">Cancel</a>
</form>