<?php

    require("config.php");
    $contentid = getUnescapedGET("contentid");
    
    if (!$contentid) {
        trigger_error("Content ID is required", E_USER_ERROR);
    }
    
    $query = "select *
                from help_content hc
               where hc.id  = " . urlencode($contentid);
    
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Could not get content information", E_USER_ERROR);
    }
    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
    layout_begin();
    
?>

<table class="FormTable">
<form action="UpdateContent.php" method="POST">
<input type="hidden" name="contentid" value="<?= $contentid ?>" />
<input type="hidden" name="sectionid" value="<?= $row['helpsectionid'] ?>" />
<input type="hidden" name="orig_title" value="<?= $row['title'] ?>">
<input type="hidden" name="orig_displayorder" value="<?= $row['displayorder'] ?>">
<input type="hidden" name="orig_content" value="<?= $row['content'] ?>">
<tr class="FormTable">
<th class="FormTable">Content Title</th>
<td>
<input type="text" name="title" value="<?= $row['title'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Display Order</th>
<td>
<input type="text" name="displayorder" value="<?= $row['displayorder'] ?>" size="10" maxlength="10"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable" valign=top>Content</th>
<td>
<textarea name="content" rows=9 cols=50><?= $row['content'] ?></textarea>
</td>
</tr>

<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Update Help Content">
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();
    
?>    