<?php

    require("config.php");
    
    $in['description'] = getUnescapedPost("description");
    $in['path'] = getUnescapedPost("path");
    $in['name'] = getUnescapedPost("name");
    $in['type'] = getUnescapedPost("type");
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
    else if (!$in['type']) {
        trigger_error("Resource type is required", E_USER_ERROR);
    }
    else if ($in['type'] == TYPE_URL && !$in['path']) {
        trigger_error("URL is required", E_USER_ERROR);
    }
    else if ($in['type'] == TYPE_FILE_PATH && !$in['path']) {
        trigger_error("URL is required", E_USER_ERROR);
    }
    else if ($in['type'] == TYPE_LOCAL_FILE && $_FILES['filename']['error'] != 0) {
        trigger_error("File Upload failed", E_USER_ERROR);
    }
    
    if ($in['type'] == TYPE_LOCAL_FILE) {
        $in['path'] = $_FILES['filename']['name'];
        $basepath = $config['path']['filestore'];
        
        if (! file_exists($basepath)) {      
            trigger_error("Upload Directory does not exist. ($basepath)", E_USER_ERROR);
        }
        
        $md5 = md5_file($_FILES['filename']['tmp_name']);
        $dir1 = substr($md5, 0, 2);
        $dir2 = substr($md5, 2, 2);
        $savedir = $basepath . "/" . $dir1;
        
        if (! file_exists($savedir)) {      
            if (! mkdir($savedir)) {
                trigger_error("Could not create dir1. ($savedir)", E_USER_ERROR);
            }
        }
        $savedir = $savedir . "/" . $dir2;
        
        if (! file_exists($savedir)) {      
            if (! mkdir($savedir)) {
                trigger_error("Could not create dir2. ($savedir)", E_USER_ERROR);
            }
        }
        
        if (!move_uploaded_file($_FILES['filename']['tmp_name'], $savedir . "/" . $md5)) {
             trigger_error("Could not move file into place.", E_USER_ERROR);
        }
        
        $query = "insert into resource (name, path, description, type, uid, md5, mimetype) values (" .
             $conn->quote($in['name']) . ", " .
             $conn->quote($in['path']) . ", " .
             $conn->quote($in['description']) . ", " .
             $conn->quote($in['type']) . ", " .
             $conn->quote($config['local']['user']['uid']) . ", " .
             $conn->quote($md5) . ", " .
             $conn->quote($_FILES['filename']['type']) . ")";
    }
    else {
        $query = "insert into resource (name, path, description, type, uid) values (" .
                 $conn->quote($in['name']) . ", " .
                 $conn->quote($in['path']) . ", " .
                 $conn->quote($in['description']) . ", " .
                 $conn->quote($in['type']) . ", " .
                 $conn->quote($config['local']['user']['uid']) . ")";
    }
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
<pre>
<?php print_r($_FILES) ?>
</pre>
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