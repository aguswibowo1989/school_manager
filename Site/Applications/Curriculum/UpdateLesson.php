<?php

    require_once("config.php");
    
    $action = getUnescapedPOST("action");
    
    $vars = array();
    $vars['lessonid'] = getUnescapedPOST("lessonid");
    
    $vars['level'] = getUnescapedPOST("level");
    $vars['subject'] = getUnescapedPOST("subject");
    $vars['topic'] = getUnescapedPOST("topic");
    $vars['unit'] = getUnescapedPOST("unit");
    $vars['name'] = getUnescapedPOST("name");
    $vars['author'] = getUnescapedPOST("author");
    $vars['school'] = getUnescapedPOST("school");
    $vars['description'] = getUnescapedPOST("description");
    
    $vars['orig_levelid'] = getUnescapedPOST("orig_levelid");
    $vars['orig_subjectid'] = getUnescapedPOST("orig_subjectid");
    $vars['orig_topicid'] = getUnescapedPOST("orig_topicid");
    $vars['orig_unitid'] = getUnescapedPOST("orig_unitid");
    $vars['orig_name'] = getUnescapedPOST("orig_name");
    $vars['orig_author'] = getUnescapedPOST("orig_author");
    $vars['orig_school'] = getUnescapedPOST("orig_school");
    $vars['orig_description'] = getUnescapedPOST("orig_description");

    
    if ($action ==  "Cancel") {
        header("Location:  ViewLesson.php?" . urlencode($lessonid));
        exit();
    }

    if (! $vars['lessonid']) {
        trigger_error("Lesson ID is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['level']) {
        trigger_error("Level is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['subject']) {
        trigger_error("Subject is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['topic']) {
        trigger_error("Topic is a require parameter", E_USER_ERROR);
    }

    if (! $vars['unit']) {
        trigger_error("Unit is a require parameter", E_USER_ERROR);
    }

    $vars['levelid'] = curriculum_add_answer("level", "name", $vars['level']);
    $vars['subjectid'] = curriculum_add_answer("subject", "name", $vars['subject']);
    $vars['topicid'] = curriculum_add_answer("topic", "name", $vars['topic']);
    $vars['unitid'] = curriculum_add_answer("unit", "name", $vars['unit']);
    
    if ($vars['orig_name'] != $vars['name']) {
        $query = "update lesson set name = " . $conn->quote($vars['name']) . " where id = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson name." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_author'] != $vars['author']) {
        $query = "update lesson set author = " . $conn->quote($vars['author']) . " where id = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson author." , E_USER_ERROR);
        }
    }

    if ($vars['orig_school'] != $vars['school']) {
        $query = "update lesson set school = " . $conn->quote($vars['school']) . " where id = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson school." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_description'] != $vars['description']) {
        $query = "update lesson set description = " . $conn->quote($vars['description']) . " where id = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson description." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_levelid'] != $vars['levelid']) {
        $query = "update lstul set levelid = " . $conn->quote($vars['levelid']) . 
                 " where lessonid = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson level." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_subjectid'] != $vars['subjectid']) {
        $query = "update lstul set subjectid = " . $conn->quote($vars['subjectid']) . 
                 " where lessonid = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson subject." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_topicid'] != $vars['topicid']) {
        $query = "update lstul set topicid = " . $conn->quote($vars['topicid']) . 
                 " where lessonid = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson topic." , E_USER_ERROR);
        }
    }

    if ($vars['orig_unitid'] != $vars['unitid']) {
        $query = "update lstul set unitid = " . $conn->quote($vars['unitid']) . 
                 " where lessonid = " . $conn->quote($vars['lessonid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update lesson unit." , E_USER_ERROR);
        }
    }

    header("Location:  ViewLesson.php?lessonid=" . urlencode($vars['lessonid']));
 
?>
