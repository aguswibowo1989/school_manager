<?php

    require("config.php");
    
    $path = getUnescapedPost("path");
    $name = getUnescapedPost("name");
    $type = getUnescapedPost("type");
    $lessonid = getUnescapedPost("lessonid");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    else if (!$name) {
        trigger_error("Name is required", E_USER_ERROR);
    }
    else if (!$type) {
        trigger_error("Resource type is required", E_USER_ERROR);
    }
    else if ($type == TYPE_URL && !$path) {
        trigger_error("URL is required", E_USER_ERROR);
    }
    else if ($type == TYPE_FILE_PATH && !$path) {
        trigger_error("URL is required", E_USER_ERROR);
    }
    else if ($type == TYPE_LOCAL_FILE && $_FILES['filename']['error'] != 0) {
        trigger_error("File Upload failed", E_USER_ERROR);
    }
    
    if ($type == TYPE_LOCAL_FILE) {
        $path = $_FILES['filename']['name'];
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
        
        $query = "insert into resource (name, path, type, uid, md5, mimetype) values (" .
             $conn->quote($name) . ", " .
             $conn->quote($path) . ", " .
             $conn->quote($type) . ", " .
             $conn->quote($config['local']['user']['uid']) . ", " .
             $conn->quote($md5) . ", " .
             $conn->quote($_FILES['filename']['type']) . ")";
    }
    else {
        $query = "insert into resource (name, path, type, uid) values (" .
                 $conn->quote($name) . ", " .
                 $conn->quote($path) . ", " .
                 $conn->quote($type) . ", " .
                 $conn->quote($config['local']['user']['uid']) . ")";
    }
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create resource", E_USER_ERROR);
    }
    
    $resourceid = db_get_insert_id("resource_id_seq");
    
    $query = "insert into lesson_resource (lessonid, resourceid) values (" .
             $conn->quote($lessonid) . ", " .
             $conn->quote($resourceid) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create resource", E_USER_ERROR);
    }

    header("Location: ViewResources.php?lessonid=" . urlencode($lessonid));
    
?>
