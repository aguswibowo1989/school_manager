<?php

    require("config.php");
    
    $lessonid = getUnescapedGET("lessonid");

    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": View Resources";
    
    $query = "select *
                from lesson_resource lr 
                join resource r on (lr.resourceid = r.id)
               where lr.lessonid = " . urlencode($lessonid);
    
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Could not get resources", E_USER_ERROR);
    } 

    layout_begin();
    show_breadcrumb_lesson($lessonid);

?>

<div id=bar>
    <a href="ViewTestBank.php?lessonid=<?= urlencode($lessonid) ?>">Test Bank</a>
    <a href="ViewLesson.php?lessonid=<?= urlencode($lessonid) ?>">Lesson</a>
    <a href="NewResource.php?lessonid=<?= urlencode($lessonid) ?>&type=<?= TYPE_URL ?>">New URL (Web Site)</a>
    <a href="NewResource.php?lessonid=<?= urlencode($lessonid) ?>&type=<?= TYPE_LOCAL_FILE ?>">New File (Document)</a
    <a href="NewResource.php?lessonid=<?= urlencode($lessonid) ?>&type=<?= TYPE_FILE_PATH ?>">New Path (CD)</a>
</div>

<table cellpadding=2 cellspacing=0 border=0 width=100% 
       style="margin-top: 10px;border-bottom-style: solid;border-bottom-width: thin;">
<?php 
    $count = 0;

    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) { 
        $count++;

        if ($count % 2) {
            $style = "background: #ffffff;";
        }
        else {
            $style = "background: #ffffff;";
        }

        if ($row['type'] == TYPE_URL) {
            $t = "URL (Web Site)";
        }
        else if ($row['type'] == TYPE_LOCAL_FILE) {
            $t = "File (Document)";
        }
        else if ($row['type'] == TYPE_FILE_PATH) {
            $t = "Path (CD)";
        }

?>

<tr style="<?= $style ?>">
<td width=100% style="border-top-style: solid;border-top-width: thin;"><?= $row['name'] ?> -- <?= $t ?></td>
<td style="border-top-style: solid;border-top-width: thin;padding:3px;" nowrap>
    <a href="OpenResource.php?resourceid=<?= urlencode($row['id']) ?>" target="<?= $row['id'] ?>">
    <img src="<?= $config['local']['icons'] ?>tb_open.gif" border=0 
             alt="Delete Lesson" align=middle> Open</a>
&nbsp;&nbsp;
    <a href="EditResource.php?resourceid=<?= urlencode($row['id']) ?>">
    <img src="<?= $config['local']['icons'] ?>tb_edit.gif" border=0 
             alt="Delete Lesson" align=middle> Edit</a></td>
</tr>

<?php } ?>
</table>

<?php

    layout_end();

?>
