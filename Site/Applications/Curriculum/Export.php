<?php

    require("config.php");
    
    $levelid = getUnescapedGET("levelid");
    $subjectid = getUnescapedGET("subjectid");
    $topicid = getUnescapedGET("topicid");
    $unitid = getUnescapedGET("unitid");
    $lessonid = getUnescapedGET("lessonid");
    
    $lessonids = get_lessonids($levelid, $subjectid, $topicid, $unitid, $lessonid);
    
    if (count($lessonids) == 0) {
        trigger_error("No Lessons to Export", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": Export";
    layout_begin();
    show_breadcrumb($levelid, $subjectid, $topicid, $unitid);
?>
<h1>Export these lessons:</h1>
<p>Uncheck the lessons to omit from the export file.</p>
<form action="DoExport.php" method="GET">
<ul>
<?php
    foreach ($lessonids as $lessonid) {
        $lesson = get_lesson($lessonid);
        echo "<li><input type=checkbox name=lessonids[] value=$lessonid checked>\n";
        echo "<a href=\"ViewLesson.php?lessonid=" . $lessonid . "\">" . $lesson['name'] . "</a>";
        
        if ($lesson['author']) {
            echo " by " . $lesson['author'];
        }
        
        if ($lesson['school']) {
            echo " at " . $lesson['school'];
        }
        echo "</li>\n\n";
    }
?>
</ul>
<input type=submit name=action value="Export">
</form>

<?php
    
    layout_end();

?>