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
        trigger_error("Unit ID is required", E_USER_ERROR);
    }
    
    $query = "select lesson.id as id, lesson.name as name,
                     lesson.author as author, lesson.school as school  
                from lstul 
                join lesson on (id = lessonid)
               where lstul.levelid = " . $conn->quote($in['levelid']) . "
                 and lstul.subjectid = " . $conn->quote($in['subjectid']) . " 
                 and lstul.topicid = " . $conn->quote($in['topicid']) . " 
                 and lstul.unitid = " . $conn->quote($in['unitid']) . " 
               group by id";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query);
        trigger_error($result->getMessage());
        trigger_error("Could not get lessons", E_USER_ERROR);
    } 
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid'], $in['unitid']);
    
?>

<h2>Choose Lesson:</h2>
<ul>
<?php 
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        $var = array('lessonid' => $row['id']);
?>
<li><a href="ViewLesson.php?<?= http_build_simple_query($var) ?>"><?= $row['name'] ?></a> 

<?php if ($row['author']) { ?>
 by <?= $row['author'] ?> 
<?php } ?>

<?php if ($row['school']) { ?>
 at <?= $row['school'] ?></li>
 <?php } ?>
<?php 
    } 
    $var = array('levelid'=> $in['levelid'],
                 'subjectid' => $in['subjectid'],
                 'topicid' => $in['topicid'],
                 'unitid' => $in['unitid']);
?>

<li><a href="NewLesson.php?<?= http_build_simple_query($var) ?>">Add New Lesson...</a></li>
</ul>

<?php
    
    layout_end();

?>
