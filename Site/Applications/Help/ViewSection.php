<?php

    require("config.php");
    
    $sectionid = getUnescapedGet('sectionid');
    
    if (!$sectionid) {
        trigger_error("Section ID is required", E_USER_ERROR);
    }
    $qsectionid = $conn->quote($sectionid);
    $section_name = get_section_name($sectionid);
    $query = "select c.title, c.content
                from help_content c
               where c.helpsectionid = $qsectionid";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($result->getMessage());
        trigger_error($query);
        trigger_error("Help section information is unavailable", E_USER_ERROR);
    }
    
    layout_begin();
    
?>

<h2><?= $section_name ?> 
<a href="Home.php">[ TOC ]</a></h2>

<?php
    
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        print "<h3>" . $row['title'] . "</h3>\n";
        print "<p>" . nl2br($row['content']) . "<p>\n";
    }

?>
<table>
<tr>
<td>
<form name="NewContent" action="NewContent.php" method="GET">
<input type=hidden name=sectionid value="<?= $sectionid ?>">
<input type=submit name=action value="New Help Content">
</form>
</td>
<td>
<form name="EditSection" action="EditSection.php" method="GET">
<input type=hidden name=sectionid value="<?= $sectionid ?>">
<input type=submit name=action value="Edit Section">
</form>
</td>
</tr>
</table>
<?php
    
    layout_end();

?>
