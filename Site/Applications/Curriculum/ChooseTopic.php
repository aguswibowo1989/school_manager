<?php

    require("config.php");
    
    $in['topicid'] = NEW_ANSWER;
    $in['subjectid'] = getUnescapedGet("subjectid");
    $in['levelid'] = getUnescapedGet("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    
    $query = "select topic.id as id, topic.name as name 
                from lstul 
                join topic on (id = topicid)
               where lstul.levelid = " . $conn->quote($in['levelid']) . "
                 and lstul.subjectid = " . $conn->quote($in['subjectid']) . " 
               group by id";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query);
        trigger_error($result->getMessage());
        trigger_error("Could not get topics", E_USER_ERROR);
    } 
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    show_breadcrumb($in['levelid'], $in['subjectid']);
    
?>
<div id=bar>
    <a href="Search.php?<?= http_build_simple_query($in) ?>">Search Subject</a>
    <a href="EditCategory.php?<?= http_build_simple_query($in) ?>">Edit Subject</a>
    <a href="Export.php?<?= http_build_simple_query($in) ?>">Export Subject</a>
</div>
<strong>Choose Topic: &nbsp;</strong>
<a href="NewTopic.php?<?= http_build_simple_query($in) ?>">Add New Topic...</a>
<ul>
<?php

    if ($result->numRows() == 0) {
        echo "<li>No Topics</li>\n";
    }
    
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        $var = array('levelid'=> $in['levelid'],
                     'subjectid' => $in['subjectid'],
                     'topicid' => $row['id']);
?>
<li><a href="NewTopic.php?<?= http_build_simple_query($var) ?>"><?= $row['name'] ?></a></li>
<?php 
    } 
    $var = array('levelid'=> $in['levelid'],
                     'subjectid' => $in['subjectid'],
                     'topicid' => NEW_ANSWER);
?>

</ul>

<?php
    
    layout_end();

?>
