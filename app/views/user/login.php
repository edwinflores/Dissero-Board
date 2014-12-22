<h2><font face="christmaseve" style="font-size: 75px">Log-in Screen</font></h2><br />

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
    <label><font face="moon flower bold" style="font-size: 30px">Username:</font></label>
    <input type="text" name="username" required>
    <label><font face="moon flower bold" style="font-size: 30px">Password:</font></label>
    <input type="password" name="password" required>
    <input type="hidden" name="page_next" value="lobby"><br />
    <button type="submit" class="btn btn-primary"><font face="bebas">Submit</font></button>
</form>

<div>
    <font face="moon flower bold" style="font-size: 30px">Register here:</font><br />
    <a class="btn btn-primary" href="<?php eh(url('user/register')) ?>"><font face="bebas">Register</font></a>
</div>
