<?php

    require("config.php");
    
    $lessonid = getUnescapedGET("lessonid");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $lesson = get_lesson($lessonid);
    $config['local']['title'] = $config['local']['name'] . ": " . $lesson['name']   ;
    layout_begin();
    show_breadcrumb_lesson($lessonid) 

?>

<div id=bar>
    <strong>Lesson</strong>
    <a class=DataView href="ViewResources.php?lessonid=<?= urlencode($lessonid) ?>">Resources</a>
    <a class=DataView href="ViewTestBank.php?lessonid=<?= urlencode($lessonid) ?>">Test Bank</a>
</div>
<div id=bar>
    <a class=DataView href="Export.php?lessonid=<?= urlencode($lessonid) ?>">Export Lesson</a>
    <a class=DataView href="EditLesson.php?lessonid=<?= urlencode($lessonid) ?>">Edit Lesson</a>
    <a class=DataView href="DeleteLesson.php?lessonid=<?= urlencode($lessonid) ?>">Delete Lesson</a>
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
