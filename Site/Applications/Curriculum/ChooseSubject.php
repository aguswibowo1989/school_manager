<?php

    require("config.php");
    
    $in['levelid'] = getUnescapedGet("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    
    $sql = "select id, name from subject";
    $res = $conn->query($sql);
    
    if (DB::isError($res)) {
        trigger_error("Unable to get levels", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="NewSubject.php" method="POST">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<tr class="FormTable">
<th class="FormTable">Choose Subject</th>
<td>
<select name="subjectid">
<option value="<?= NO_ANSWER ?>">Choose One:</option>
<?php while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) { ?>
<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
<?php } ?>

<option value="<?= NEW_ANSWER ?>">Add New Subject...</option>
</select>  
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Next &gt;&gt;">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
