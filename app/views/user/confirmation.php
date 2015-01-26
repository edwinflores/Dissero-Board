<h2>eMail Verification</h2>
<?php if ($confirmed) : ?>
    <p class="alert alert-success">
        Your eMail address has been verified!
    </p>
<?php else : ?>
    <p class="alert alert-block">
        Invalid Code!
    </p>
<?php endif ?>

<a class='btn btn-primary' href="<?php encode_string(url('user/login'))?>">Go to login page</a>
