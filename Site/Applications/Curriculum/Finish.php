<?php

    require("config.php");    
    $lessonid = getUnescapedGET("lessonid");
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    
?>

<table class="FormTable">
<form action="ViewLesson.php" method="GET">
<input type=hidden name=lessonid value="<?= $lessonid ?>">
<tr class="FormTable">
<th class="FormTable">Lesson Plan Successfully Added</th>
</tr>
<tr>
<td class="FormTable">
Click on "Finish" to view the new lesson plan.  While viewing the lesson
plan, you will have the oppurtunity to add resources and assessment
questions to the lessson.

</td>
</tr>
<tr class="FormTable">
<td class="FormTable">
<input type=submit name=action value="Finish">
</td>
</tr>
</form>
</table>


<?php

    layout_end();
    
?>
