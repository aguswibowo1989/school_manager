<?php

    require("config.php");
    
    $sectionid = getUnescapedGET("sectionid");

    if (!$sectionid) {
        trigger_error("Section ID is required", E_USER_ERROR);
    }
    
    $query = "select *
                from help_section hs
               where hs.id  = " . urlencode($sectionid);
    
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Could not get section information", E_USER_ERROR);
    }
    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    layout_begin();

?>

<table class="FormTable">
<form action="UpdateSection.php" method="POST">
<input type="hidden" name="sectionid" value="<?= $sectionid ?>">
<input type="hidden" name="orig_name" value="<?= $row['name'] ?>">
<input type="hidden" name="orig_displayorder" value="<?= $row['displayorder'] ?>">
<tr class="FormTable">
<th class="FormTable">Section Name</th>
<td>
<input type="text" name="name" value="<?= $row['name'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Display Order</th>
<td>
<input type="text" name="displayorder" value="<?= $row['displayorder'] ?>" size="10" maxlength="10"/>
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Update Section">
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php

    layout_end();

?>
