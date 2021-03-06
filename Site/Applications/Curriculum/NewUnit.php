<?php

    require("config.php");
    $in['unitid'] = getUnescapedGET("unitid");
    $in['topicid'] = getUnescapedGET("topicid");
    $in['subjectid'] = getUnescapedGET("subjectid");
    $in['levelid'] = getUnescapedGET("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if (!$in['topicid']) {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if (!$in['unitid']) {
        trigger_error("Unit ID is required", E_USER_ERROR);
    }
    else if ($in['unitid'] >= 0) {
        header("Location: ChooseLesson.php?" . http_build_simple_query($in));
        exit();
    }
    else if ($in['unitid'] == NO_ANSWER) {
        trigger_error("Unit ID is required", E_USER_ERROR);
    }
    else if ($in['unitid'] == ADD_ANSWER) {
        $id = curriculum_add_answer(getUnescapedGET("table"), 
                                    getUnescapedGET("column"),
                                    getUnescapedGET("answer"));
        $in['unitid'] = $id;
        header("Location: ChooseLesson.php?" . http_build_simple_query($in));
        exit();
    }
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid']);
    
?>

<table class="FormTable">
<form action="NewUnit.php" method="GET">
<input type="hidden" name="unitid" value="<?= ADD_ANSWER ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="table" value="unit">
<input type="hidden" name="column" value="name">
<tr class="FormTable">
<th class="FormTable">Unit Name</th>
<td>
<input type="text" name="answer" value="" size="40" maxlength="100"/>
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Create">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();
    
?>    