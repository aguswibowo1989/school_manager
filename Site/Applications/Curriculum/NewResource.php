<?php

    require("config.php");
    
    $lessonid = getUnescapedGet("lessonid");
    $type = getUnescapedGet("type");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }

    if (!$type) {
        trigger_error("Type is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    show_breadcrumb_lesson($lessonid);
    
?>

<table class="FormTable">
<form action="AddResource.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="lessonid" value="<?= $lessonid ?>">
<input type="hidden" name="type" value="<?= $type ?>">

<tr class="FormTable">
<th class="FormTable">Resource Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<?php if ($type == TYPE_URL) { ?>

<tr class="FormTable">
<th class="FormTable">Web Link (URL)</th>
<td>
<input type="text" name="path" value="" size="40"/>
</td>
</tr>

<?php } else if ($type == TYPE_FILE_PATH) { ?>

<tr class="FormTable">
<th class="FormTable">File/CD Path</th>
<td>
<input type="text" name="path" value="" size="40"/>
</td>
</tr>

<?php } else if ($type == TYPE_LOCAL_FILE) { ?>

<tr class="FormTable">
<th class="FormTable">File Path</th>
<td>
<input type="file" name="filename" value="" size="40"/>
</td>
</tr>

<?php } ?>


<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable"><input type=submit name=action value="Create Resource"></td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
