<?php

    require("config.php");
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
  
?>

<table class="FormTable">
<form action="NewLevel.php" method="POST">
<tr class="FormTable">
<th class="FormTable">Choose Level</th>
<td>
<?php echo show_level_select("Choose One:", "",  "EnableAddNew"); ?>
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
