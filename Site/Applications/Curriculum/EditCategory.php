<?php

    require("config.php");
    $in['unitid'] = getUnescapedGET("unitid");
    $in['topicid'] = getUnescapedGET("topicid");
    $in['subjectid'] = getUnescapedGET("subjectid");
    $in['levelid'] = getUnescapedGET("levelid");
    
    if ($in['levelid'] > 0) {
        $table = "level";
        $name = "Level";
        $value = get_name_from_id("level", "id", $in['levelid']);
        $level = $value;
    }
    
    if ($in['subjectid'] > 0) {
        $table = "subject";
        $name = "Subject";
        $value = get_name_from_id("subject", "id", $in['subjectid']);
        $subject = $value;
    }

    if ($in['topicid'] > 0) {
        $table = "topic";
        $name = "Topic";
        $value = get_name_from_id("topic", "id", $in['topicid']);
        $topic = $value;
    }
    
    if ($in['unitid'] > 0) {
        $table = "unit";
        $name = "Unit";
        $value = get_name_from_id("unit", "id", $in['unitid']);
        $unit = $value;
    }
    
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid'], $in['unitid']);
    
?>

<table class="FormTable">
<form action="UpdateCategory.php" method="GET">
<input type="hidden" name="unitid" value="<?= $in['unitid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="table" value="<?= $table ?>">
<tr class="FormTable">
<th class="FormTable"><?= $name ?> Name</th>
<td>
<input type="text" name="answer" value="<?= $value ?>" size="40" maxlength="100"/>
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Update">

</td>
</tr>
</form>
</table>

<?php
    
    layout_end();
    
?>    