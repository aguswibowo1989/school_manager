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

        <a class=DataView href="Export.php?lessonid=<?= urlencode($lessonid) ?>">
        <img src="<?= $config['local']['icons'] ?>tb_save.gif" border=0 
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
    <h3><?= $lesson['school'] ?></h3>
    <h3><?= $lesson['author'] ?></h3>
    </td>
    <td align=right valign=top>
    <h3><?= get_name_from_id("level", "id", $lesson['levelid']) ?></h2>
    <h3><?= $lesson['t'] ?></h3>
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
