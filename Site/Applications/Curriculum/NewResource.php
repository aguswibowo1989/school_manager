<?php

    require("config.php");
    
    $in['lessonid'] = getUnescapedGet("lessonid");
    
    if (!$in['lessonid']) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource (URL)";
    layout_begin();
    
?>

<table class="FormTable">
<form action="AddResource.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="lessonid" value="<?= $in['lessonid'] ?>">

<tr class="FormTable">
<th class="FormTable">Short Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Web Link (URL)</th>
<td>
<input type="text" name="path" value="" size="40"/>
</td>
</tr>

<?php if ($in['type'] == TYPE_FILE_PATH) { ?>

<tr class="FormTable">
<th class="FormTable">File/CD Path</th>
<td>
<input type="text" name="path" value="" size="40"/>
</td>
</tr>

<?php } else if ($in['type'] == TYPE_LOCAL_FILE) { ?>

<tr class="FormTable">
<th class="FormTable">File/CD Path</th>
<td>
<input type="file" name="filename" value="" size="40"/>
</td>
</tr>

<?php } ?>


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
