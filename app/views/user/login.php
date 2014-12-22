<h2>Log-in Screen</h2><br />

<?php
	if(isset($user)){
		if (!$user->isLoginValid()):
			echo $user->isLoginValid();
	?>
	<div class="alert">
		<div>Invalid Username and/or Password</div>
	</div>
<?php endif; }  ?>

<form class="well" method="POST" action="<?php eh(url('user/login'))?>">
	<label>Username:</label><br />
	<input type="text" name="username" required>
	<label>Password:</label><br />
	<input type="password" name="password" required>
	<input type="hidden" name="page_next" value="lobby"><br />
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<div>
	Register here:<br />
	<a class="btn btn-primary" href="<?php eh(url('user/register')) ?>">Register</a>
</div>
