<?php

    require("config.php");
    
    $in['subjectid'] = NEW_ANSWER;
    $in['levelid'] = getUnescapedGet("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    
    $query = "select subject.id as id, subject.name as name 
                from lstul 
                join subject on (id = subjectid)
               where lstul.levelid = " . $conn->quote($in['levelid']) . " 
               group by id";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query);
        trigger_error($result->getMessage());
        trigger_error("Could not get subjects", E_USER_ERROR);
    }
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb($in['levelid']);
?>
<div id=bar>
    <a href="Search.php?<?= http_build_simple_query($in) ?>">Search Level</a>
    <a href="EditCategory.php?<?= http_build_simple_query($in) ?>">Edit Level</a>
    <a href="Export.php?<?= http_build_simple_query($in) ?>">Export Level</a>
</div>
<strong>Choose Subject: &nbsp;</strong>
<a href="NewSubject.php?<?= http_build_simple_query($in) ?>">Add New Subject...</a>
<ul>
<?php 
    
    if ($result->numRows() == 0) {
        echo "<li>No Subjects</li>\n";
    }
    
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        $var = array('levelid'=> $in['levelid'],
                     'subjectid' => $row['id']);
?>
<li><a href="NewSubject.php?<?= http_build_simple_query($var) ?>"><?= $row['name'] ?></a></li>
<?php 
    } 
    $var = array('levelid'=> $in['levelid'],
                 'subjectid' => NEW_ANSWER);
?>

</ul>

<?php
    
    layout_end();

?>
