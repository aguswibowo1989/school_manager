<?php

    require("config.php");
    
    $in['type'] = getUnescapedGet("type");
    $in['topicid'] = getUnescapedGet("topicid");
    $in['subjectid'] = getUnescapedGet("subjectid");
    $in['levelid'] = getUnescapedGet("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if (!$in['topicid']) {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if (!$in['type']) {
        trigger_error("Resource type is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="AddResource.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="type" value="<?= $in['type'] ?>">

<tr class="FormTable">
<th class="FormTable">Resource Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<?php if ($in['type'] == TYPE_URL) { ?>

<tr class="FormTable">
<th class="FormTable">Web Link (URL)</th>
<td>
<input type="text" name="path" value="" size="40"/>
</td>
</tr>

<?php } else if ($in['type'] == TYPE_FILE_PATH) { ?>

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
<th class="FormTable" valign=top>Description and <br>Instructions</th>
<td>
<textarea name="description" rows=12 cols=40></textarea>
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
