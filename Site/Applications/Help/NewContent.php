<?php

    require("config.php");
    $sectionid = getUnescapedGET("sectionid");
    layout_begin();
    
?>

<table class="FormTable">
<form action="AddContent.php" method="POST">
<input type="hidden" name="sectionid" value="<?= $sectionid ?>" />

<tr class="FormTable">
<th class="FormTable">Content Title</th>
<td>
<input type="text" name="title" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Display Order</th>
<td>
<input type="text" name="displayorder" value="" size="10" maxlength="10"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Content</th>
<td>
<textarea name="content" rows=9 cols=50></textarea>
</td>
</tr>

<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Create Content">
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();
    
?>    