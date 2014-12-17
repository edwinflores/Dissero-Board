<h1>All threads</h1>

<ul>
	<?php foreach ($threads as $v): ?>
	<li>
		<a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
		<?php eh($v->title) ?></a>
	</li>
	<?php endforeach ?>
</ul>

<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
<br />
<br />
<a class="btn btn btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>