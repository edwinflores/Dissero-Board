<h2><font style="font-size: 30px">Welcome to your Profile!</font></h2>

<form class="well" method="post" action="<?php encode_string(url('user/profile')) ?>">
	<label><font style="font-size: 20px">Username:</font></label>
    <input type="text" class="span3" name="username" value="<?php encode_string($user->username) ?>" ><br>
    <br>
    <label><font style="font-size: 20px">Password:</font></label>
    <input type="password" class="span3" name="password" value="<?php encode_string(encrypt_decrypt('decrypt', $user->password))?>" ><br>
    <br>
    <label><font style="font-size: 20px">Email Address:</font></label>
    <font style="font-size: 15px"><?php echo readable_text(encode_string($user->email)) ?></font><br><br>
    <label><font style="font-size: 18px">Verified: </font></label>
        <?php if ($user->verified): ?>
            Yes
        <?php else : ?>
            No
        <?php endif ?>
    <br><br>
    <label><font style="font-size: 20px">Rank</font></label>
    
   	<font style="font-size: 15px"><?php echo readable_text($user->getRank()) ?></font>
    <br />
   	<label><font style="font-size: 20px">Comment count</font></label>
   	<font style="font-size: 15px"><?php echo readable_text($user->comment_count) ?></font>
    <br />
    <label><font style="font-size: 20px">Remaining comments until Rank Up</font></label>
    <font style="font-size: 15px"><?php echo readable_text($nextRank) ?></font>
    <br />
    <label><font style="font-size: 20px">Member Since:</font></label>
    <font style="font-size: 15px"><?php echo readable_text($user->created) ?></font>
    <br />

    <input type="hidden" name="page_next" value="profile_update">
    <br /><button type="submit" class="btn btn-primary">Save</button>
</form>

<br />
<a class="btn btn-danger" href="<?php encode_string(url('user/delete')) ?>">Delete Account</a>

<br /><br />
<a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>
