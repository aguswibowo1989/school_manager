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

<tr class="FormTable">
<th class="FormTable">Level</th>
<td>
<?php echo show_level_select("Choose:", "", "Normal", $resource['levelid']); ?>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Subject</th>
<td>
<?php echo show_subject_select("Choose:", "",  "Normal", $resource['levelid'], $resource['subjectid']); ?>
</td>

</tr>
<tr class="FormTable">
<th class="FormTable">Topic</th>
<td>
<?php echo show_topic_select("Choose:", "",  "Normal", $resource['levelid'], $resource['subjectid'], $resource['topicid']); ?>
</td>
</tr>

<input type="hidden" name="orig_levelid" value="<?= $resource['levelid'] ?>">
<input type="hidden" name="orig_subjectid" value="<?= $resource['subjectid'] ?>">
<input type="hidden" name="orig_topicid" value="<?= $resource['topicid'] ?>">
<input type="hidden" name="orig_resourcetype" value="<?= $resource['type'] ?>">
<input type="hidden" name="orig_name" value="<?= $resource['name'] ?>">
<input type="hidden" name="orig_path" value="<?= $resource['path'] ?>">
<input type="hidden" name="orig_description" value="<?= $resource['description'] ?>">
<input type="hidden" name="resourceid" value="<?= $resource['resourceid'] ?>">
<input type="hidden" name="resourcetype" value="<?= $resource['type'] ?>">

<tr class="FormTable">
<th class="FormTable">Resource Name</th>
<td>
<input type="text" name="name" value="<?= $resource['name'] ?>" size="40" maxlength="100"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable">Web Link (URL)</th>
<td>
<input type="text" name="path" value="<?= $resource['path'] ?>" size="40"/>
</td>
</tr>

<tr class="FormTable">
<th class="FormTable" valign=top>Description</th>
<td>
<textarea name="description" rows=6 cols=40><?= $resource['description'] ?></textarea>
</td>
</tr>

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
