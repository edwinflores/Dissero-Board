<div float:right>
    <a class="btn btn btn-primary" href="<?php encode_string(url('user/profile')) ?>">View Profile</a> |||
    <a class="btn btn btn-success" href="<?php encode_string(url('user/ranking')) ?>">View Top Ten</a> |||
    <a class="btn btn btn-info" href="<?php encode_string(url('user/userlist')) ?>">View User List</a> |||
    <a class="btn btn btn-danger" href="<?php encode_string(url('user/logout')) ?>">Logout</a>
</div>
<hr width="75%" align="center" size="8" noshade>
<h2><font style="font-size: 40px">Dissero Threads</font></h2>
<hr width="75%" align="center" size="8" noshade>
<ul type="circle" compact>
    <?php foreach ($threads as $row): ?>
    <li>
        <font style="font-size: 18px"><strong>
        <a href="<?php encode_string(url('comment/view', array('thread_id' => $row->id))) ?>">
        <?php encode_string($row->title) ?></strong></a></font><br>
        <font style="font-size: 14px">
        <i>Created: </i><?php encode_string(time_ago($row->created)) ?></font>
    </li>
    <br />
    <?php endforeach ?>
</ul>
<hr width="75%" align="center" size="8" noshade>    
<div class="pagination">
    <font style="font-size: 15px">
    <?php if($pagination->current > 1): ?>
        &nbsp;<a class='btn btn-primary' href='?page=<?php encode_string($pagination->prev) ?>'>Previous</a>
    <?php endif ?>

    &nbsp; <?php echo $page_links; ?> &nbsp;&nbsp;&nbsp;

    <?php if(!$pagination->is_last_page): ?>
        &nbsp;<a class='btn btn-primary' href='?page=<?php encode_string($pagination->next) ?>'>Next</a>
    <?php endif ?>
    </font>
</div>

<a class="btn btn-large btn-primary" href="<?php encode_string(url('thread/create')) ?>">Create a Thread</a>
