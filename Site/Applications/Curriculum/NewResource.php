<?php

    require("config.php");
    
    $in['resourcetype'] = getUnescapedGet("resourcetype");
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
    else if (!$in['resourcetype']) {
        trigger_error("Resource type is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="AddResource.php" method="POST">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="resourcetype" value="<?= $in['resourcetype'] ?>">

<tr class="FormTable">
<th class="FormTable">Resource Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Web Link (URL)</th>
<td>
<input type="text" name="url" value="" size="40"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable" valign=top>Description</th>
<td>
<textarea name="description" rows=6 cols=40></textarea>
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
