<?php

    require("config.php");
    $in['topicid'] = getUnescapedPost("topicid");
    $in['subjectid'] = getUnescapedPost("subjectid");
    $in['levelid'] = getUnescapedPost("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if (!$in['topicid']) {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if ($in['topicid'] >= 0) {
        header("Location: ChooseResourceType.php?" . http_build_simple_query($in));
        exit();
    }
    else if ($in['topicid'] == NO_ANSWER) {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if ($in['topicid'] == ADD_ANSWER) {
        $in['topicid'] = curriculum_add_answer();
        header("Location: ChooseResourceType.php?" . http_build_simple_query($in));
        exit();
    }
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="NewTopic.php" method="POST">
<input type="hidden" name="topicid" value="<?= ADD_ANSWER ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="table" value="topic">
<input type="hidden" name="column" value="name">
<tr class="FormTable">
<th class="FormTable">Topic Name</th>
<td>
<input type="text" name="answer" value="" size="40" maxlength="100"/>
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