<?php

    require("config.php");
    $in['subjectid'] = getUnescapedGET("subjectid");
    $in['levelid'] = getUnescapedGET("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if ($in['subjectid'] >= 0) {
        header("Location: ChooseTopic.php?" . http_build_simple_query($in));
        exit();
    }
    else if ($in['subjectid'] == NO_ANSWER) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if ($in['subjectid'] == ADD_ANSWER) {
        $id = curriculum_add_answer(getUnescapedGET("table"), 
                                    getUnescapedGET("column"),
                                    getUnescapedGET("answer"));
        $in['subjectid'] = $id;
        header("Location: ChooseTopic.php?" . http_build_simple_query($in));
        exit();
    }
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb($in['levelid']);
    
?>

<table class="FormTable">
<form action="NewSubject.php" method="GET">
<input type="hidden" name="subjectid" value="<?= ADD_ANSWER ?>">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="table" value="subject">
<input type="hidden" name="column" value="name">
<tr class="FormTable">
<th class="FormTable">Subject Name</th>
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