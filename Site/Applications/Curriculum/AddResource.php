<?php

    require("config.php");
    
    $in['description'] = getUnescapedPost("description");
    $in['url'] = getUnescapedPost("url");
    $in['name'] = getUnescapedPost("name");
    $in['resourcetype'] = getUnescapedPost("resourcetype");
    $in['topicid'] = getUnescapedPost("topicid");
    $in['subjectid'] = getUnescapedPost("subjectid");
    $in['levelid'] = getUnescapedPost("levelid");
    
    if (!$in['levelid']) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid']) {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if (!$in['topicid']) {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if (!$in['name']) {
        trigger_error("Name is required", E_USER_ERROR);
    }
    else if (!$in['resourcetype']) {
        trigger_error("Resource type is required", E_USER_ERROR);
    }
    else if ($in['resourcetype'] == "url" && !$in['url']) {
        trigger_error("URL is required", E_USER_ERROR);
    }
    
    $query = "insert into resource (name, path, description, type, uid) values (" .
             $conn->quote($in['name']) . ", " .
             $conn->quote($in['url']) . ", " .
             $conn->quote($in['description']) . ", " .
             $conn->quote($in['resourcetype']) . ", " .
             $conn->quote($config['local']['user']['uid']) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create resource", E_USER_ERROR);
    }
    
    $in['resourceid'] = db_get_insert_id("resource_id_seq");
    
    $query = "insert into lstr (levelid, subjectid, topicid, resourceid) values (" .
             $conn->quote($in['levelid']) . ", " .
             $conn->quote($in['subjectid']) . ", " .
             $conn->quote($in['topicid']) . ", " .
             $conn->quote($in['resourceid']) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create resource", E_USER_ERROR);
    }
    
    layout_begin();
    
?>

<table class="FormTable">
<form action="ViewResources.php" method="GET">
<tr class="FormTable">
<th class="FormTable">Resource Successfully Added</th>
<td>
&nbsp;
</td>
</tr>
<tr class="FormTable">
<td class="FormTable">&nbsp;</td>
<td class="FormTable">
<input type=submit name=action value="Finish">
</td>
</tr>
</form>
</table>


<?php

    layout_end();
    
?>