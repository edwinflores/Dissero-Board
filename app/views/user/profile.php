<h5><font style="font-size: 30px">(/^▽^)/</font></h5>
<h2><font style="font-size: 35px">Welcome to your Profile!</font></h2>
<hr width="75%" align="center" size="8" noshade>

<?php if ($user->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Invalid Username/Password input</h4>

        <?php if ($user->validation_errors['username']['length']): ?>
            <div>
                <em>Username</em> must be between
                <?php encode_string($user->validation['username']['length'][1]) ?> and
                <?php encode_string($user->validation['username']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>

        <?php if ($user->validation_errors['password']['length']): ?>
            <div>
                <em>Password</em> must be between
                <?php encode_string($user->validation['password']['length'][1]) ?>
                and
                <?php encode_string($user->validation['password']['length'][2]) ?>.
            </div>
        <?php endif ?>

        <?php if ($user->validation_errors['username']['format']): ?>
            <div>
               Username must be alphanumeric characters only.
            </div>
        <?php endif ?>

        <?php if ($user->validation_errors['username']['duplicate']): ?>
            <div>
                The username
                <em><?php encode_string($user->username) ?></em>
                is already registered, please use another.
            </div>
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well" method="post" action="<?php encode_string(url('user/profile')) ?>">
	<label><font style="font-size: 20px">Username:</font></label>
    <input type="text" class="span3" name="username" value="<?php encode_string($user->username) ?>" required><br><br>
    <label><font style="font-size: 20px">Password:</font></label>
    <input type="password" class="span3" name="password" value="<?php encode_string(encrypt_decrypt('decrypt', $user->password))?>" required><br><br>
    <input type="hidden" name="page_next" value="profile_update">
    <button type="submit" class="btn btn-success">Save</button>
    <br>
    <hr width="25%" align="center" size="5" noshade>
    <label><font style="font-size: 20px">Email Address:</font></label>
    <font style="font-size: 15px"><?php echo readable_text(encode_string($user->email)) ?></font><br><br>
    <label><font style="font-size: 18px">Verified: </font></label>
        <?php if ($user->verified): ?>
            Yes
        <?php else : ?>
            No
        <?php endif ?>
    <hr width="25%" align="center" size="5" noshade>
    <label><font style="font-size: 20px">Rank:</font></label>
   	<font style="font-size: 15px"><?php echo readable_text($user->getRank()) ?></font>
    <br><br>
   	<label><font style="font-size: 20px">Number of Comments:</font></label>
   	<font style="font-size: 15px"><?php echo readable_text($comment_count) ?></font>
    <br><br>
    <label><font style="font-size: 20px">Remaining comments until Rank Up:</font></label>
    <font style="font-size: 15px"><?php echo readable_text($nextRank) ?></font>
    <br><br>
    <hr width="25%" align="center" size="5" noshade>
    <label><font style="font-size: 20px">Member Since:</font></label>
    <font style="font-size: 15px"><?php echo readable_text(time_ago($user->created)) ?></font>
    <br>
</form>
<hr width="75%" align="center" size="8" noshade>
<div float:left>
<a class="btn btn-danger" href="<?php encode_string(url('user/delete')) ?>">Delete Account</a> |||
<a class="btn btn-primary" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>
