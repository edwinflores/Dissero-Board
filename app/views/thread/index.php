<h1>All threads</h1>

<ul>
	<?php foreach ($threads as $row): ?>
	<li>
		<a href="<?php eh(url('comment/view', array('thread_id' => $row->id))) ?>">
		<?php eh($row->title) ?></a>
	</li>
	<?php endforeach ?>

	<div class="pagination">
		<?php if($pagination->current > 1): ?>
			<a class='btn btn-primary' href='?page=<?php eh($pagination->prev) ?>'>Previous</a>
		<?php endif ?>

		<?php echo $page_links ?>

		<?php if(!$pagination->is_last_page): ?>
			<a class='btn btn-primary' href='?page=<?php eh($pagination->next) ?>'>Next</a>
		<?php endif ?>
	</div>
</ul>

<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
<br />
<br />
<a class="btn btn btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>