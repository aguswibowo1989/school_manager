<?php

    require("config.php");
    
    $query = "select s.id, s.name as section, c.title as content 
                from help_section s 
                left join help_content c on (s.id = c.helpsectionid) 
               order by s.displayorder";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($result->getMessage());
        trigger_error($query);
        trigger_error("Help information is unavailable", E_USER_ERROR);
    }
    
    layout_begin();
    
?>

<?php
    
    $current_section = null;
    print "<ul>\n";
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
        
        if ($row['section'] != $current_section) {
            if ($current_section != null) {
                print "</ul>\n</li>\n";
            }
            print "<li><a href=\"ViewSection.php?sectionid={$row['id']}\">" . $row['section'] . "</a>\n";
            print "<ul>\n";
        }
        if ($row['content']) {
            print "<li>" . $row['content'] . "</li>\n";
        }
        $current_section = $row['section'];  
    }
    print "</ul>\n</li>\n</ul>\n";

    if (!$config['local']['disable_update']) {
?>
<table>
<tr>
<td>
<form name="NewSection" action="NewSection.php" method="GET">
<input type=submit name=action value="New Help Section">
</form>
</td>
</tr>
</table>
<?php
    }
    
    layout_end();

?>
