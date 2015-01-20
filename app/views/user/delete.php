<h2><font style="font-size: 30px">Warning!</font></h2>
<p class='alert alert-block'>
    You cannot recover your account once deleted. Are you sure you wish to continue?
</p>

<form class="well" method="post" action ="<?php encode_string(url('user/delete')) ?>">
	<button type="submit" class="btn btn-danger" value="1" name='delete'>Delete Account</button>
</form>

<br />
<a class="btn btn-primary" href="<?php encode_string(url('user/profile')) ?>">Back to Profile</a>
