<?php

    require("config.php");
    
    $sql = "select id, name from level";
    $res = $conn->query($sql);
    
    if (DB::isError($res)) {
        trigger_error("Unable to get levels", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
  
?>

<table class="FormTable">
<form action="NewLevel.php" method="POST">
<tr class="FormTable">
<th class="FormTable">Choose Level</th>
<td>
<select name="levelid">
<option value="<?= NO_ANSWER ?>">Choose One:</option>
<?php while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) { ?>
<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
<?php } ?>

<option value="<?= NEW_ANSWER ?>">Add New Level...</option>
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
