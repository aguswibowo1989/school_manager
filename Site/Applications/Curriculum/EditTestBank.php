<?php

    require("config.php");
    
    $lessonid = getUnescapedGET("lessonid");

    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    
    $config['local']['title'] = $config['local']['name'] . ": View Test Bank";
    
    $query = "select *
                from lesson_testbank lt
                join testbank t on (lt.testbankid = t.id)
               where lt.lessonid = " . urlencode($lessonid);
    
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
    <a href="ViewLesson.php?lessonid=<?= urlencode($lessonid) ?>">Lesson</a>
    <a href="ViewResources.php?lessonid=<?= urlencode($lessonid) ?>">Resources</a>
    <strong>Test Bank</strong>
</div>
<div id=bar>
    <a href="ViewTestBank.php?lessonid=<?= urlencode($lessonid) ?>">View Test</a>
    <a href="ViewTestKey.php?lessonid=<?= urlencode($lessonid) ?>">View Test Key</a>
    <strong>Edit Test</strong>
    <a href="NewTestQuestion.php?lessonid=<?= urlencode($lessonid) ?>">New Test Question</a>
</div>

<table cellpadding=2 cellspacing=0 border=0 width=100% 
       style="margin-top: 10px;border-bottom-style: solid;border-bottom-width: thin;">
<?php while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) { ?>

<tr style="background: #ffffff;">
<td width=100% style="border-top-style: solid;border-top-width: thin;">
<strong>Question:</strong><br><?= ereg_replace("\r\n", "<br>\r\n", $row['question']) ?><br><br>
<strong>Answer:</strong><br> <?= ereg_replace("\r\n", "<br>\r\n", $row['answer']) ?></td>
<td style="border-top-style: solid;border-top-width: thin;padding:3px;" nowrap valign=top>
    <a href="EditTestQuestion.php?testbankid=<?= urlencode($row['id']) ?>">
    <img src="<?= $config['local']['icons'] ?>tb_edit.gif" border=0 
             alt="Edit Test Question" align=middle> Edit</a><br>
    <a href="DeleteTestQuestion.php?testbankid=<?= urlencode($row['id']) ?>">
    <img src="<?= $config['local']['icons'] ?>tb_trash.gif" border=0 
             alt="Edit Test Question" align=middle> Delete</a></td>
</tr>

<?php } ?>
</table>

<?php

    layout_end();

?>
