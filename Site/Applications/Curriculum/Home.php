<?php

    require("config.php");

    $query = "select level.name as name, level.id as levelid, count(*) as num
                from lstul 
                join level on (lstul.levelid = level.id) 
               group by level.id 
               order by num desc
               limit 8";
    $levelres = $conn->query($query);

    if (DB::isError($levelres)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($levelres->getMessage(), E_USER_NOTICE);
        trigger_error("Unable to get counts of lessons", E_USER_ERROR);
    }

    $query = "select level.name as level, subject.name as subject, 
                     lesson.name as name, lesson.author, lesson.id as lessonid
                from lstul 
                join level on (lstul.levelid = level.id) 
                join subject on (lstul.subjectid = subject.id) 
                join lesson on (lstul.lessonid = lesson.id)
               order by lstul.timestamp desc limit 8;";
    $newestres = $conn->query($query);

    if (DB::isError($newestres)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($newestres->getMessage(), E_USER_NOTICE);
        trigger_error("Unable to get newest lessons", E_USER_ERROR);
    }
    
    layout_begin();
    
?>

<h1>Lesson Plan Manager</h1>

<p>Lesson Plans and ideas are stored in this curriculum web application.  Click on 
"Lesson Plans" in the left column to view or add lesson plans.  The lesson
plans are organized by level, subject, topic, and unit.  Each lesson plan
may contain test items, document, video that accompany step by step
instructions on how to prepare and execute on the lesson.</p>

<h2>Import/Export Curriculums</h2>

<p>Share resources with others or incorporate resources from other teachers.
Where you see the "Export" Option, You will be able to save one or more
lesson plans at a time.</p>

<table width=100%>

<tr>
<td width=50% valign=top>
<strong>Newest Lesson Plans</strong>
<ul>
<?php while ($row = $newestres->fetchrow(DB_FETCHMODE_ASSOC)) { ?>
<li><a href="ViewLesson.php?lessonid=<?= urlencode($row['lessonid']); ?>">
<?php echo $row['name'] ?></a> by <i><?php echo $row['author'] ?></i></li>    
<?php } ?>
</ul>
</td>

<td width=50% valign=top>
<strong>Lesson Plans per Level</strong>
<ul>
<?php while ($row = $levelres->fetchrow(DB_FETCHMODE_ASSOC)) { ?>
<li><a href="ChooseSubject.php?levelid=<?= urlencode($row['levelid']) ?>">
<?php echo $row['name'] ?></a> (<?php echo $row['num'] ?>)</li>    
<?php } ?>
</ul>
</td>
</tr>
</table>



<?php
    
    layout_end();

?>
