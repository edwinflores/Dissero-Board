<h1><font face="christmaseve" style="font-size: 50px">All threads</font></h1>

<ul>
    <?php foreach ($threads as $row): ?>
    <li>
        <font face="moon flower bold" style="font-size: 30px">
        <a href="<?php eh(url('comment/view', array('thread_id' => $row->id))) ?>">
        <?php eh($row->title) ?></a>
        </font>
    </li>
    <br />
    <?php endforeach ?>

    <div class="pagination">
        <font face="bebas" style="font-size: 15px">
        <?php if($pagination->current > 1): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php eh($pagination->prev) ?>'>Previous</a>
        <?php endif ?>

        &nbsp; <?php echo $page_links; ?> &nbsp;&nbsp;&nbsp;

        <?php if(!$pagination->is_last_page): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php eh($pagination->next) ?>'>Next</a>
        <?php endif ?>
        </font>
    </div>
</ul>

<font face="bebas">
    <a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
    <br />
    <br />
    <a class="btn btn btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>
</font>