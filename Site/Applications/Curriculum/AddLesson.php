<?php

    require("config.php");
    
    $in['description'] = getUnescapedPost("description");
    $in['author'] = getUnescapedPost("author");
    $in['name'] = getUnescapedPost("name");
    $in['school'] = getUnescapedPost("school");
    $in['unitid'] = getUnescapedPost("unitid");
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
    else if (!$in['unitid']) {
        trigger_error("Unit ID is required", E_USER_ERROR);
    }
    else if (!$in['name']) {
        trigger_error("Name is required", E_USER_ERROR);
    }
    else if (!$in['description']) {
        trigger_error("Description is required", E_USER_ERROR);
    }
    
    $query = "insert into lesson (name, author, description, school, uid) values (" .
             $conn->quote($in['name']) . ", " .
             $conn->quote($in['author']) . ", " .
             $conn->quote($in['description']) . ", " .
             $conn->quote($in['school']) . ", " .
             $conn->quote($config['local']['user']['uid']) . ")";

    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create lesson", E_USER_ERROR);
    }
    
    $in['lessonid'] = db_get_insert_id("lesson_id_seq");
    
    $query = "insert into lstul (levelid, subjectid, topicid, unitid, lessonid) values (" .
             $conn->quote($in['levelid']) . ", " .
             $conn->quote($in['subjectid']) . ", " .
             $conn->quote($in['topicid']) . ", " .
             $conn->quote($in['unitid']) . ", " .
             $conn->quote($in['lessonid']) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create lesson", E_USER_ERROR);
    }
    
    header("Location: Finish.php?lessonid=" . urlencode($in['lessonid']));
    
