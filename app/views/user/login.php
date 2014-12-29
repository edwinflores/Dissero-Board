<h2><font style="font-size: 50px">Log-in Screen</font></h2><br />

<?php
    if (!$user->isLoginValid()):
    ?>
    <div class="alert">
        <div>Invalid Username and/or Password</div>
    </div>
<?php endif; ?>

<form class="well" method="POST" action="<?php encodeString(url('user/login'))?>">
    <label><font style="font-size: 20px">Username:</font></label>
    <input type="text" name="username" required>
    <label><font style="font-size: 20px">Password:</font></label>
    <input type="password" name="password" required>
    <input type="hidden" name="page_next" value="lobby"><br />
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div>
    <font style="font-size: 18px">Register here:</font><br />
    <a class="btn btn-primary" href="<?php encodeString(url('user/register')) ?>">Register</a>
</div>
