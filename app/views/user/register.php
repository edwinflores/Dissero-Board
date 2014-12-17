<h2>Registration Page</h2>

<?php if ($user->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error</h4>

		<?php if ($user->validation_errors['username']['length']): ?>
			<div>
				<em>Username</em> must be between
				<?php eh($user->validation['username']['length'][1]) ?> and
				<?php eh($user->validation['username']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['password']['length']): ?>
			<div>
				<em>Password</em> must be between
				<?php eh($user->validation['password']['length'][1]) ?>
				<?php eh($user->validation['password']['length'][2]) ?>
			</div>
		<?php endif ?>
	</div>
<?php endif ?>

<form class="well" method="POST" action="<?php eh(url('user/register')) ?>">
	<label>Username</label><br />
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>" required><br />

	<label>Password</label><br />
	<input type="password" class="span2" name="password" required><br />

	<input type="hidden" name="page_next" value="register_end">
	<button type="submit" class="btn btn-primary">Register</button>
</form>

<div>
	<em>If you already have an account, log-in here:</em><br />
	<a class="btn btn-danger" href="<?php eh(url('user/login')) ?>">Login</a>
</div>