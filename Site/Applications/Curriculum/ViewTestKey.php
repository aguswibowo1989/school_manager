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
    $lesson = get_lesson($lessonid);
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
    <strong>View Test Key</strong>
    <a href="EditTestBank.php?lessonid=<?= urlencode($lessonid) ?>">Edit Test</a>
    <a href="NewTestQuestion.php?lessonid=<?= urlencode($lessonid) ?>">New Test Question</a>
</div>

<div id=test>
<h1><?= $lesson['name'] ?> (Test Key)</h1>
<ol>
<?php while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) { ?>
<li><?= nl2br(ereg_replace(" ", "&nbsp;",ereg_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $row['question']))) ?><br><br>
<strong>Answer: &nbsp;</strong><?= nl2br(ereg_replace(" ", "&nbsp;",ereg_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $row['answer']))) ?>
</li>
<?php } ?>
</ol>
</div>

<?php

    layout_end();

?>

