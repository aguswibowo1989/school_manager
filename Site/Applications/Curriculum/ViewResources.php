<?php

    require("config.php");
    
    $levelid = getUnescapedGET("levelid");
    $subjectid = getUnescapedGET("subjectid");
    $topicid = getUnescapedGET("topicid");
    $search = getUnescapedGET("search");
    $page_num = getUnescapedGET("page_num");
    
    $var = array();
    
    if (!$page_num) {
        $page_num = 1;
    }
     $var['page_num'] = $page_num;
    
    $where = " where 1=1 ";
    
    if ($levelid > 0) {
        $where .= " and levelid = " . $conn->quote($levelid) . " ";
        $var['levelid'] = $levelid;
    }
    
    if ($subjectid > 0) {
        $where .= " and subjectid = " . $conn->quote($subjectid) . " ";
        $var['subjectid'] = $subjectid;
    }
    
    if ($topicid > 0) {
        $where .= " and topicid = " . $conn->quote($topicid) . " ";
        $var['topicid'] = $topicid;
    }
    
    $query = "select count(*)
                from lstr 
                join resource r on (lstr.resourceid = r.id)
                join subject s on  (lstr.subjectid = s.id)
                join level l on (lstr.levelid = l.id)
                join topic t on (lstr.topicid = t.id) " . $where;
    $result = $conn->query($query);
    $row = $result->fetchRow();
    $total_count = $row[0];
    $result->free();
    $viewing_start =  ($page_num - 1) * $config['local']['display_per_page'] + 1;
    $viewing_end =  ($page_num - 1) * $config['local']['display_per_page'] + $config['local']['display_per_page'];
    
    $config['local']['title'] = $config['local']['name'] . ": View Resources";
    
    $query = "select l.name as level, s.name as subject, t.name as topic, 
                     r.name as resource, r.timestamp as created, 
                     r.description as description, r.type as type, 
                     r.path as path, r.id as resourceid
                from lstr 
                join resource r on (lstr.resourceid = r.id)
                join subject s on  (lstr.subjectid = s.id)
                join level l on (lstr.levelid = l.id)
                join topic t on (lstr.topicid = t.id)";
    
    $query .= $where;   
    $query .= " order by level, subject, topic, resource ";
    $query .= " limit {$config['local']['display_per_page']} offset " . ($page_num - 1) * $config['local']['display_per_page'];
                
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error("Database Query Failed", E_USER_NOTICE);
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Could not get resources", E_USER_ERROR);
    } 
    layout_begin();

?>

<table width=100% cellpadding=0 cellspacing=0 border=0>
<form action="" method="GET">
<tr>
<td align=left width=33%>
<?php echo show_level_select("Show All Levels", "Level: ", "SubmitOnChange", $levelid); ?>
</td>
<td align=center width=33%>
<?php echo show_subject_select("Show All Subjects", "Subject: ", "SubmitOnChange", $levelid, $subjectid); ?>
</td>
<td align=right width=33%>
<?php echo show_topic_select("Show All Topics", "Topic: ", "SubmitOnChange", $levelid, $subjectid, $topicid); ?>
</td>
</tr>
</form>
</table>

<?php layout_display_pagnation_bar($page_num, $viewing_start, $viewing_end, $total_count, "ViewResources.php", $var); ?>

<?php
        
    $count = 0;
    
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {

        if ($count % 2) {
            $class = "data_table_0";
        }
        else {
            $class = "data_table_1";
        }
        $count++;
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="DataView">
<tr> 
<th class="DataView" colspan=3><?php echo $row['resource']; ?></th>
</tr>
<tr> 
<td class="DataView" width=33%><strong>Level:</strong> <?php echo $row['level']; ?></td>
<td class="DataView" width=33%><strong>Subject:</strong> <?php echo $row['subject']; ?></td>
<td class="DataView" width=33%><strong>Topic:</strong> <?php echo $row['topic']; ?></td>
</tr>
<tr> 
<td class="DataView" colspan=3>
<hr>
<?php echo ereg_replace("\r\n", "<br>\n", htmlentities($row['description'])); ?>
<hr>
</td>
</tr>

<tr>
<td class="DataView">

<a class=DataView href="EditResource.php?resourceid=<?= urlencode($row['resourceid']) ?>&<?= http_build_simple_query($var) ?>">
<img src="<?= $config['local']['icons'] ?>tb_edit.gif" border=0 alt="Edit Resource" align=middle> Edit</a>
&nbsp;&nbsp;
<a class=DataView href="DeleteResource.php?resourceid=<?= urlencode($row['resourceid']) ?>&<?= http_build_simple_query($var) ?>">
<img src="<?= $config['local']['icons'] ?>tb_trash.gif" border=0 alt="Delete Resource" align=middle> Delete</a>

</td>
<td>&nbsp;
</td>

<td align=right>
<a class=DataView href="ExportResources.php?resource[]=<?= urlencode($row['resourceid']) ?>">
<img src="<?= $config['local']['icons'] ?>tb_save.gif" border=0 alt="Open Resource" align=middle> Export</a>
&nbsp;&nbsp;
<a class=DataView href="OpenResource.php?resourceid=<?= urlencode($row['resourceid']) ?>&<?= http_build_simple_query($var) ?>">
<img src="<?= $config['local']['icons'] ?>tb_open.gif" border=0 alt="Open Resource" align=middle> Open</a>
</td>
</table>

<?php

    }    

    layout_display_pagnation_bar($page_num, $viewing_start, $viewing_end, $total_count, "ViewResources.php", $var);
    layout_end();

?>
