<?php

    require("config.php");
    $in['lessonid'] = NEW_ANSWER;
    $in['unitid'] = getUnescapedGet("unitid");
    $in['topicid'] = getUnescapedGet("topicid");
    $in['subjectid'] = getUnescapedGet("subjectid");
    $in['levelid'] = getUnescapedGet("levelid");

    $config['local']['title'] = $config['local']['name'] . ": Search";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid'], $in['unitid']);
?>

Enter the search terms for your search.  Fill in one or more boxes.  The search
will treat each box filled in as a logical 'AND'.  Also, then search result will 
only apply the lesson plan level, subject, topic, or unit specified in the
breadcrumbs above.
<table class="FormTable">
<form action="DoSearch.php" method="GET">
<input type="hidden" name="unitid" value="<?= $in['unitid'] ?>">
<input type="hidden" name="topicid" value="<?= $in['topicid'] ?>">
<input type="hidden" name="subjectid" value="<?= $in['subjectid'] ?>">
<input type="hidden" name="levelid" value="<?= $in['levelid'] ?>">

<tr class="FormTable">
<th class="FormTable">Lesson Plan Name</th>
<td>
<input type="text" name="search_name" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Lesson Plan Author</th>
<td>
<input type="text" name="search_author" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Lesson Plan School</th>
<td>
<input type="text" name="search_school" value="" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Lesson Plan Content</th>
<td>
<input type="text" name="search_content" value="" size="40" maxlength="100"/>
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Search">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
