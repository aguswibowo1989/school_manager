<?php

    require("config.php");
    $config['local']['title'] = $config['local']['name'] . ": Import";
    layout_begin();
    show_breadcrumb();
?>

<table class="FormTable">
<form action="DoImport.php" method="POST" enctype="multipart/form-data">
<tr class="FormTable">
<th class="FormTable">Import File</th>
<td>
<input type="file" name="import"/>
</td>
</tr>

<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Import">
</td>
</tr>
</form>
</table>


<?php
    
    layout_end();

?>
