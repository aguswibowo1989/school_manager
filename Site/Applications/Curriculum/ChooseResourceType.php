<?php

    require("config.php");
    
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
    
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="NewResource.php" method="GET">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<tr class="FormTable">
<th class="FormTable">Choose Resource Type</th>
<td>
<select name="resourcetype">
<option value="<?= NO_ANSWER ?>">Choose One:</option>
<option value="url">Web Link</option>
<option value="file">File Upload</option>
<option value="path">File on disk or CD</option>
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
