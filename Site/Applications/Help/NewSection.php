<?php

    require("config.php");
    
    layout_begin();
    
?>

<table class="FormTable">
<form action="AddSection.php" method="POST">
<tr class="FormTable">
<th class="FormTable">Section Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Display Order</th>
<td>
<input type="text" name="displayorder" value="" size="10" maxlength="10"/>
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Create Section">
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();
    
?>    