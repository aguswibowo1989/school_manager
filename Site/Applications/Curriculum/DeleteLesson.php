<?php

    require_once("config.php");
    
    $lessonid = getUnescapedGET("lessonid");
    $action = getUnescapedGET("action");
    
    if (! $lessonid) {
        trigger_error("Lesson ID is a require parameter", E_USER_ERROR);
    }

    $lesson = get_lesson($lessonid);

    $vars = array();
    $vars['levelid'] = $lesson['levelid'];
    $vars['subjectid'] = $lesson['subjectid'];
    $vars['topicid'] = $lesson['topicid'];
    $vars['unitid'] = $lesson['unitid'];
    $vars['lessonid'] = $lessonid;
    
    
    if ($action == "Yes") {
        /*
        $resource = get_resource($resourceid);
        
        if ($resource['type'] == TYPE_LOCAL_FILE) {
             $file = $config['path']['filestore'] . "/" .
                     substr($resource['md5'], 0, 2) . "/" . 
                     substr($resource['md5'], 2, 2) . "/" . $resource['md5'];
             if (file_exists($file)) {
                if (!unlink($file)) {
                    trigger_error("Failed to delete file", E_USER_ERROR);
                }
             }
        }
        */
        $sql = "delete from lesson where id = '$lessonid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from lesson table" , E_USER_ERROR);
        }
        $sql = "delete from lstul where lessonid = '$lessonid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Could not delete from lstr table" , E_USER_ERROR);
        }
        
        header("Location:  ChooseLesson.php?" . http_build_simple_query($vars));
    }
    elseif ($action == "No") {
        header("Location:  ViewLesson.php?lessonid=" . urlencode($lessonid));
    }
    else {
        layout_display_dialog("Are you sure you want to delete the resource named '{$lesson['name']}'?", "YesNo", $vars);
    }
 
?>
