<?php

    require("config.php");
    
    $lessonid = getUnescapedGET("lessonid");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $lesson = get_lesson($lessonid);
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb_lesson($lessonid) 

?>

<div id=actions>

        <a class=DataView href="ViewResources.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_open.gif" border=0 
             alt="Delete Lesson" align=middle> View Test Bank</a>

        <a class=DataView href="ViewResources.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_open.gif" border=0 
             alt="Delete Lesson" align=middle> View Resources</a>

        <a class=DataView href="Export.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_save_as.gif" border=0 
             alt="Delete Lesson" align=middle> Export</a>

        <a class=DataView href="EditLesson.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_edit.gif" border=0 
             alt="Edit Lesson" align=middle> Edit</a>

        <a class=DataView href="DeleteLesson.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_trash.gif" border=0 
             alt="Delete Lesson" align=middle> Delete</a>

</div>

<hr>
<table width=100%>
    <tr>
    <td valign=top colspan=2 align=center>
    <h1><?= $lesson['name'] ?></h1>
    </td>
    </tr>
    <tr>
    <td valign=top>
    <strong><?= $lesson['school'] ?></strong><br>
    <strong><?= $lesson['author'] ?></strong>
    </td>
    <td align=right valign=top>
    <strong><?= get_name_from_id("level", "id", $lesson['levelid']) ?>
    </strong><br>
    <strong><?= $lesson['t'] ?></strong>
    </td>
    </tr>
</table>
<hr>
<div id=lesson-plan>
<?= $lesson['description'] ?>
</div>

<?php

    layout_end();

?>
