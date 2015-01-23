<hr width="75%" align="center" size="8" noshade>
<h1 align="left">(•̀ᴗ•́)و ̑̑ Top Commenters!</h1>
<hr width="75%" align="center" size="8" noshade>
<ul type="square">
    <?php foreach ($users as $key => $value): ?>
    	<div class="user"><li>
    		<div class="meta">
                <font style="font-size: 18px"><u><?php encode_string($value->username) ?></u><br /> 
                <font style="font-size: 16px"><b>Rank : </b><?php encode_string(User::get($value->id)->getRank()) ?><br />
                <font style="font-size: 18px"><b>Comments : </b><?php encode_string($value->getCommentCount()) ?>
                </font>
            </div>
    	</div>
        <br />
        </li>
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
<br />

<a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>