<?php

    require("config.php");
    
    $in['unitid'] = getUnescapedGet("unitid");
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
    else if (!$in['unitid']) {
        trigger_error("Unit ID type is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid'], $in['unitid']);
    
?>

<table class="FormTable">
<form action="AddLesson.php" method="POST" enctype="multipart/form-data" onSubmit='updateRTE("description");'>
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="unitid" value="<?= $in['unitid'] ?>">

<tr class="FormTable">
<th class="FormTable">Lesson Plan Name</th>
<td>
<input type="text" name="name" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Lesson Plan Author</th>
<td>
<input type="text" name="author" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">School of Author</th>
<td>
<input type="text" name="school" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable" valign=top colspan=2>Description and Instructions</th>
</tr>

<tr>
<td colspan=2>
<script language="JavaScript" type="text/javascript">

//Usage: initRTE(imagesPath, includesPath, cssFile)
initRTE("<?= $config['local']['images'] ?>rte/", "<?= $config['local']['home'] ?>Utils/", "<?= $config['path']['style'] ?>lesson-plan.css");

//Usage: writeRichText(fieldname, html, width, height, buttons)
writeRichText("description", 
              "<?= RTESafe("<h1>Objective:</h1><h1>Summary:</h1><h1>Materials:</h1><h1>Procedures:</h1><h1>Teaching Tips:</h1><h1>Additional Activity:</h1><h1>Assessment:</h1><h1>Handouts:</h1>") ?>", 
              550, 250, true, false);
</script>
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
