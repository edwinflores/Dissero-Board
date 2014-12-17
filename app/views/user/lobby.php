<h2>Hello <?php eh($_SESSION['username'])?>!</h2>
<p class='alert alert-success'>
	You're now logged in to your account.
</p>
<a class="btn btn-primary" href="<?php eh(url('thread/index')) ?>">View the threads</a>
