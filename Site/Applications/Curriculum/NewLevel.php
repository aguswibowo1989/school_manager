<?php

    require("config.php");
    $levelid = getUnescapedGET("levelid");
    
    if (!$levelid) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if ($levelid >= 0) {
        header("Location: ChooseSubject.php?levelid=" . urlencode($levelid));
        exit();
    }
    else if ($levelid == NO_ANSWER) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if ($levelid == ADD_ANSWER) {
        $id = curriculum_add_answer(getUnescapedGET("table"), 
                                    getUnescapedGET("column"),
                                    getUnescapedGET("answer"));
        header("Location: ChooseSubject.php?levelid=" . urlencode($id));
        exit();
    }
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb();
    
?>

<table class="FormTable">
<form action="NewLevel.php" method="GET">
<input type="hidden" name="levelid" value="<?= ADD_ANSWER ?>">
<input type="hidden" name="table" value="level">
<input type="hidden" name="column" value="name">
<tr class="FormTable">
<th class="FormTable">Level Name</th>
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