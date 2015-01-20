<h1><font style="font-size: 40px">Dissero Threads</font></h1>
<br />
<ul>
    <?php foreach ($threads as $row): ?>
    <li>
        <font style="font-size: 18px">
        <a href="<?php encode_string(url('comment/view', array('thread_id' => $row->id))) ?>">
        <?php encode_string($row->title) ?></a>
        </font>
    </li>
    <br />
    <?php endforeach ?>

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
</ul>


<a class="btn btn-large btn-primary" href="<?php encode_string(url('thread/create')) ?>">Create</a>
<br /><br />
<a class="btn btn-large btn-primary" href="<?php encode_string(url('user/profile')) ?>">View Profile</a>
<br /><br />
<a class="btn btn-large btn-primary" href="<?php encode_string(url('user/ranking')) ?>">View Top Ten</a>
<br /><br />
<a class="btn btn btn-primary" href="<?php encode_string(url('user/userlist')) ?>">View User List</a>
<br /><br />
<a class="btn btn btn-danger" href="<?php encode_string(url('user/logout')) ?>">Logout</a>