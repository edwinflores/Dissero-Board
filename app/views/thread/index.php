<h1><font style="font-size: 50px">All threads</font></h1>

<ul>
    <?php foreach ($threads as $row): ?>
    <li>
        <font style="font-size: 18px">
        <a href="<?php encodeString(url('comment/view', array('thread_id' => $row->id))) ?>">
        <?php encodeString($row->title) ?></a>
        </font>
    </li>
    <br />
    <?php endforeach ?>

    <div class="pagination">
        <font style="font-size: 15px">
        <?php if($pagination->current > 1): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php encodeString($pagination->prev) ?>'>Previous</a>
        <?php endif ?>

        &nbsp; <?php echo $page_links; ?> &nbsp;&nbsp;&nbsp;

        <?php if(!$pagination->is_last_page): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php encodeString($pagination->next) ?>'>Next</a>
        <?php endif ?>
        </font>
    </div>
</ul>


<a class="btn btn-large btn-primary" href="<?php encodeString(url('thread/create')) ?>">Create</a>
<br />
<br />
<a class="btn btn btn-danger" href="<?php encodeString(url('user/logout')) ?>">Logout</a>