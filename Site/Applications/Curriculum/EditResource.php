<?php

    require("config.php");
    
    $resourceid  = getUnescapedGET("resourceid");
    
    if (! $resourceid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    $resource = get_resource($resourceid);
     
    $config['local']['title'] = $config['local']['name'] . ": Edit Resource";
    layout_begin();
    
?>

<table class="FormTable">
<form action="UpdateResource.php" method="POST">

<input type="hidden" name="orig_name" value="<?= $resource['name'] ?>">
<input type="hidden" name="orig_path" value="<?= $resource['path'] ?>">
<input type="hidden" name="resourceid" value="<?= $resource['id'] ?>">
<input type="hidden" name="resourcetype" value="<?= $resource['type'] ?>">

<tr class="FormTable">
<th class="FormTable">Resource Name</th>
<td>
<input type="text" name="name" value="<?= $resource['name'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<?php if ($resource['type'] == TYPE_URL) { ?>
<tr class="FormTable">
<th class="FormTable">URL (Web Site)</th>
<td>
<input type="text" name="path" value="<?= $resource['path'] ?>" size="40"/>
</td>
</tr>
<?php } else if ($resource['type'] == TYPE_FILE_PATH) { ?>
<tr class="FormTable">
<th class="FormTable">File Path (CD)</th>
<td>
<input type="text" name="path" value="<?= $resource['path'] ?>" size="40"/>
</td>
</tr>
<?php } ?>

<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Update Resource">&nbsp;&nbsp;
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
