<h2><font face="djb coffee shoppe espresso" style="font-size: 30px">Hello <?php eh($_SESSION['username'])?>!</font></h2>
<p class='alert alert-success'>
    You're now logged in to your account.
</p>
<a class="btn btn-primary" href="<?php eh(url('thread/index')) ?>">View the threads</a>
