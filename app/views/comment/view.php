<h1><?php eh($thread->title) ?></h1>

<?php foreach ($comments as $key => $value): ?>
	<div class="comment">

		<div class="meta">
			<?php eh($key + 1) ?>: <?php eh($value->username) ?> <?php eh($value->created) ?>
		</div>

		<div>
			<?php echo readable_text($value->body) ?>
		</div>

	</div>
<?php endforeach ?>

<div class="pagination">
	<?php if($pagination->current > 1): ?>
		<a class='btn btn-small' href='?page=<?php eh($pagination->prev) ?>&thread_id=<?php eh($thread->id)?>'>Previous</a>
	<?php endif ?>

	<?php echo $page_links ?>

	<?php if(!$pagination->is_last_page): ?>
		<a class='btn btn-small' href='?page=<?php eh($pagination->next)?>&thread_id=<?php eh($thread->id)?>'>Next</a>
	<?php endif ?>
</div>

<hr>

<form class="well" method="post" action="<?php eh(url('comment/write'))?>">
	<label>Your name</label>
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
	<label>Comment:</label>
	<textarea name="body"><?php eh(Param::get('body')) ?></textarea>
	</br>
	<input type="hidden" name="thread_id" value="<?php eh($thread->id)?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<br />
<a class="btn btn-danger" href="<?php eh(url('thread/index')) ?>">Back to Index</a>
