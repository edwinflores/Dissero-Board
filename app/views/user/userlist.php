<h2><font style="font-size: 30px">ヾ(⌐■_■)ノ♪</font></h2>
<h1><font style="font-size: 45px">The User List!</font></h1>
<form class="form-search" method="GET">
    <?php if ($filter == 'Power'): ?>
    	<select name="filter" class="input-medium">
    		<option value="" disabled>Filter by</option>
    		<option value="Virtue">Virtue</option>
    		<option value="Dominion">Dominion</option>
    		<option value="Throne">Throne</option>
    		<option value="Cherubim">Cherubim</option>
    	</select>
    <?php elseif ($filter == 'Virtue'): ?>
    	<select name="filter" class="input-medium">
    		<option value="" disabled>--Rank--</option>
    		<option value="Power">Power</option>
    		<option value="Dominion">Dominion</option>
    		<option value="Throne">Throne</option>
    		<option value="Cherubim">Cherubim</option>
    	</select>
    <?php elseif ($filter == 'Dominion'): ?>
        <select name="filter" class="input-medium">
            <option value="" disabled>--Rank--</option>
            <option value="Power">Power</option>
            <option value="Virtue">Virtue</option>
            <option value="Throne">Throne</option>
            <option value="Cherubim">Cherubim</option>
        </select>
    <?php elseif ($filter == 'Throne'): ?>
        <select name="filter" class="input-medium">
            <option value="" disabled>--Rank--</option>
            <option value="Power">Power</option>
            <option value="Virtue">Virtue</option>
            <option value="Dominion">Dominion</option>
            <option value="Cherubim">Cherubim</option>
        </select>
    <?php elseif ($filter == 'Cherubim'): ?>
        <select name="filter" class="input-medium">
            <option value="" disabled>--Rank--</option>
            <option value="Power">Power</option>
            <option value="Virtue">Virtue</option>
            <option value="Dominion">Dominion</option>
            <option value="Throne">Throne</option>
        </select>
    <?php else: ?>
        <select name="filter" class="input-medium">
            <option value="" selected disabled>--Rank--</option>
            <option value="Power">Power</option>
            <option value="Virtue">Virtue</option>
            <option value="Dominion">Dominion</option>
            <option value="Throne">Throne</option>
            <option value="Cherubim">Cherubim</option>
        </select>
    <?php endif ?>
    <button type="submit" class="btn btn-info">Filter</button>
</form>
<hr width="75%" align="center" size="6" noshade>
<ul type="square">
    <?php foreach ($users as $key => $value): ?>
        <div class="user"><li>
            <div class="meta">
                <font style="font-size: 20px"><u><?php encode_string($value->username) ?></u><br /> 
                <font style="font-size: 18px"><b>Rank : </b><?php encode_string(User::get($value->id)->getRank()) ?><br />
                <font style="font-size: 20px"><b>Comments : </b><?php encode_string($value->getCommentCount()) ?>
                </font>
            </div>
        </div>
        <br />
        </li>
    <?php endforeach ?>

    <div class="pagination">
        <font style="font-size: 15px">
        <?php if($pagination->current > 1): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php encode_string($pagination->prev) ?>&filter=<?php encode_string($filter) ?>'>Previous</a>
        <?php endif ?>

        &nbsp; <?php echo $page_links; ?> &nbsp;&nbsp;&nbsp;

        <?php if(!$pagination->is_last_page): ?>
            &nbsp;<a class='btn btn-primary' href='?page=<?php encode_string($pagination->next) ?>&filter=<?php encode_string($filter) ?>'>Next</a>
        <?php endif ?>
    </font>
    </div>

</ul>

<br />

<a class="btn btn-danger" href="<?php encode_string(url('thread/index')) ?>">Back to Index</a>
