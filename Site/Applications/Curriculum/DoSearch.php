<?php

    require("config.php");
    $in['lessonid'] = NEW_ANSWER;
    $in['unitid'] = getUnescapedGet("unitid");
    $in['topicid'] = getUnescapedGet("topicid");
    $in['subjectid'] = getUnescapedGet("subjectid");
    $in['levelid'] = getUnescapedGet("levelid");
    
    $in['search_name'] = getUnescapedGet("search_name");
    $in['search_author'] = getUnescapedGet("search_author");
    $in['search_school'] = getUnescapedGet("search_school");
    $in['search_content'] = getUnescapedGet("search_content");
    
    $query = "select lesson.id as id, lesson.name as name,
                     lesson.author as author, lesson.school as school  
                from lstul 
                join lesson on (id = lessonid)
               where 1=1";
               
    if ($in['levelid'] > 0) {
        $query .= " and lstul.levelid = " . $conn->quote($in['levelid']);
    }
    
    if ($in['subjectid'] > 0) {
        $query .= " and lstul.subjectid = " . $conn->quote($in['subjectid']);
    }
    
    if ($in['topicid'] > 0) {
        $query .= " and lstul.topicid = " . $conn->quote($in['topicid']);
    }
    
    if ($in['unitid'] > 0) {
        $query .= " and lstul.unitid = " . $conn->quote($in['unitid']);
    }
    
    if ($in['search_name']) {
        $query .= " and lesson.name like " . $conn->quote('%' . $in['search_name'] . '%');
    }
    
    if ($in['search_author']) {
        $query .= " and lesson.author like " . $conn->quote('%' . $in['search_author'] . '%');
    }
    
    if ($in['search_school']) {
        $query .= " and lesson.school like " . $conn->quote('%' . $in['search_school'] . '%');
    }
    
    if ($in['search_content']) {
        $query .= " and lesson.description like " . $conn->quote('%' . $in['search_content'] . '%');
    }
                 
    $query .= " group by id";
    $result = $conn->query($query);

    $config['local']['title'] = $config['local']['name'] . ": Search";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid'], $in['topicid'], $in['unitid']);
?>

<!-- <?= $query ?> -->
<ul>
<?php 
    
    if ($result->numRows() == 0) {
        echo "<li>No Lessons</li>\n";
    }
    
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
?>

</ul>

<?php
    
    layout_end();

?>
