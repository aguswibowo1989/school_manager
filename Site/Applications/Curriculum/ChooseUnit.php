<?php

    require("config.php");
    
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
    
    $query = "select unit.id as id, unit.name as name 
                from lstul 
                join unit on (id = unitid)
               where lstul.levelid = " . $conn->quote($in['levelid']) . "
                 and lstul.subjectid = " . $conn->quote($in['subjectid']) . " 
                 and lstul.topicid = " . $conn->quote($in['topicid']) . " 
               group by id";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query);
        trigger_error($result->getMessage());
        trigger_error("Could not get topics", E_USER_ERROR);
    } 
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
    
?>

<h2>Choose Unit:</h2>
<ul>
<?php 
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        $var = array('levelid'=> $in['levelid'],
                     'subjectid' => $in['subjectid'],
                     'topicid' => $in['topicid'],
                     'unitid' => $row['id']);
?>
<li><a href="NewUnit.php?<?= http_build_simple_query($var) ?>"><?= $row['name'] ?></a></li>
<?php 
    } 
    $var = array('levelid'=> $in['levelid'],
                     'subjectid' => $in['subjectid'],
                     'topicid' => $in['topicid'],
                     'unitid' => NEW_ANSWER);
?>

<li><a href="NewUnit.php?<?= http_build_simple_query($var) ?>">Add New Unit...</a></li>
</ul>

<?php
    
    layout_end();

?>
