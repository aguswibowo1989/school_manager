<?php

    require("config.php");
    
    $lessonid = getUnescapedGet("lessonid");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": New Test Question";
    layout_begin();
    show_breadcrumb_lesson($lessonid);
    
?>

<table class="FormTable">
<form action="AddTestQuestion.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="lessonid" value="<?= $lessonid ?>">
<tr class="FormTable">
<th class="FormTable">Question</th>
</tr>

<tr>
<td>
<textarea name="question" cols=60 rows=10></textarea>
</td>
</tr>


<tr class="FormTable">
<th class="FormTable">Answer</th>
</tr>

<tr>
<td>
<textarea name="answer" cols=60 rows=5></textarea>
</td>
</tr>

<tr class="FormTable">
<td class="FormTable"><input type=submit name=action value="Create Test Question"></td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
