<?php

    require("config.php");
    
    $lessonid  = getUnescapedGET("lessonid");
    
    if (! $lessonid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    $lesson = get_lesson($lessonid);
    
    $description = RTESafe($lesson['description']);
    $config['local']['title'] = $config['local']['name'] . ": Edit Lesson";
    layout_begin();
    
?>

<table class="FormTable">
<form action="UpdateLesson.php" method="POST" onSubmit='return submitForm();'>

<tr class="FormTable">
<th class="FormTable">Level</th>
<td>
<input type="text" name="level" value="<?= get_name_from_id("level", "id", $lesson['levelid'])?>">
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Subject</th>
<td>
<input type="text" name="subject" value="<?= get_name_from_id("subject", "id", $lesson['subjectid'])?>">
</td>

</tr>
<tr class="FormTable">
<th class="FormTable">Topic</th>
<td>
<input type="text" name="topic" value="<?= get_name_from_id("topic", "id", $lesson['topicid'])?>">
</td>
</tr>

</tr>
<tr class="FormTable">
<th class="FormTable">Unit</th>
<td>
<input type="text" name="unit" value="<?= get_name_from_id("unit", "id", $lesson['unitid'])?>">
</td>
</tr>
<input type="hidden" name="lessonid" value="<?= $lessonid ?>">
<input type="hidden" name="orig_levelid" value="<?= $lesson['levelid'] ?>">
<input type="hidden" name="orig_subjectid" value="<?= $lesson['subjectid'] ?>">
<input type="hidden" name="orig_topicid" value="<?= $lesson['topicid'] ?>">
<input type="hidden" name="orig_name" value="<?= $lesson['name'] ?>">
<input type="hidden" name="orig_author" value="<?= $lesson['name'] ?>">
<input type="hidden" name="orig_school" value="<?= $lesson['name'] ?>">
<input type="hidden" name="orig_description" value='<?= $description ?>'>

<tr class="FormTable">
<th class="FormTable">Lesson Plan Name</th>
<td>
<input type="text" name="name" value="<?= $lesson['name'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Lesson Plan Author</th>
<td>
<input type="text" name="author" value="<?= $lesson['author'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">School of Author</th>
<td>
<input type="text" name="school" value="<?= $lesson['school'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable" valign=top colspan=2>Description and Instructions</th>
</tr>

<tr>
<td colspan=2 style="padding-left: 10px;padding-top: 0px;">
<small>(use [Style] for most consistant documents)</small>
<script language="JavaScript" type="text/javascript">

function submitForm() {
    updateRTE('description');
    return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile)
initRTE("<?= $config['local']['images'] ?>rte/", 
        "<?= $config['local']['home'] ?>Utils/", 
        "<?= $config['local']['style'] ?>screen.css");

//Usage: writeRichText(fieldname, html, width, height, buttons)
writeRichText('description', '<?= $description ?>', 550, 500, true, false);
</script>
</td>
</tr>

<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Update Lesson Plan">&nbsp;&nbsp;
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
