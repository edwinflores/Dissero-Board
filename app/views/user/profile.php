<h2><font style="font-size: 30px">Welcome to your Profile!</font></h2>

<form class="well" method="post" action="<?php encode_string(url('user/profile')) ?>">
	<label><font style="font-size: 20px">Username:</font></label>
    <input type="text" class="span2" name="username" value="<?php encode_string($user->username) ?>" ><br />

    <label><font style="font-size: 20px">Password:</font></label>
    <input type="password" class="span2" name="password" value="<?php encode_string($user->password)?>" ><br />

    <label><font style="font-size: 20px">Email Address:</font></label>
    <input type="email" class="span2" name="email" value="<?php encode_string($user->email) ?>" ><br />

    <label><font style="font-size: 20px">Rank</font></label>
   	<font style="font-size: 15px"><?php echo readable_text($user->rank) ?></font>

   	<label><font style="font-size: 20px">Rank</font></label>
   	<font style="font-size: 15px"><?php echo readable_text($user->comment_count) ?></font>

    <input type="hidden" name="page_next" value="profile_end">
    <br /><button type="submit" class="btn btn-primary">Save</button>
</form>

<br />
<a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>
