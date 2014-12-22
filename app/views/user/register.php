<h2><font face="christmaseve" style="font-size: 75px">Registration Page</font></h2>

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
    <label><font face="moon flower bold" style="font-size: 30px">Set Username:</font></label>
    <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>" required><br />

    <label><font face="moon flower bold" style="font-size: 30px">Set Password:</font></label>
    <input type="password" class="span2" name="password" required><br />

    <input type="hidden" name="page_next" value="register_end">
    <button type="submit" class="btn btn-primary"><font face="bebas">Register</font></button>
</form>

<div>
    <em><font face="moon flower" style="font-size: 25px">If you already have an account, log-in here:</font></em><br />
    <a class="btn btn-danger" href="<?php eh(url('user/login')) ?>"><font face="bebas">Login</font></a>
</div>