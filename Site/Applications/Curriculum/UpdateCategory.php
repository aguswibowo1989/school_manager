<?php 

    require("config.php");
    $in['unitid'] = getUnescapedGET("unitid");
    $in['topicid'] = getUnescapedGET("topicid");
    $in['subjectid'] = getUnescapedGET("subjectid");
    $in['levelid'] = getUnescapedGET("levelid");
    $in['table'] = getUnescapedGET("table");
    $in['answer'] = getUnescapedGET("answer");
    $in['action'] = getUnescapedGET("action");
    
    if (!$in['levelid'] && $in['table'] == "level") {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if (!$in['subjectid'] && $in['table'] == "subject") {
        trigger_error("Subject ID is required", E_USER_ERROR);
    }
    else if (!$in['topicid'] && $in['table'] == "topic") {
        trigger_error("Topic ID is required", E_USER_ERROR);
    }
    else if (!$in['unitid'] && $in['table'] == "unit") {
        trigger_error("Unit ID is required", E_USER_ERROR);
    }
    else if (!$in['table']) {
        trigger_error("table is required", E_USER_ERROR);
    }
    else if (!$in['answer']) {
        trigger_error("answer is required", E_USER_ERROR);
    }
    
    if ($in['action'] == "Update") {
        $id = curriculum_add_answer($in['table'], "name", $in['answer']);
        
        if ($in['table'] == "level") {
            $query = "update lstul set levelid = $id where levelid = " . $in['levelid'];
            $result = $conn->query($query);
            
            if (DB::isError($result)) {
                trigger_error("Error updating level", E_USER_ERROR);
            }
            $in['levelid'] = $id;
            header("Location: ChooseSubject.php?" . http_build_simple_query($in));
            exit();            
        }
        
        else if ($in['table'] == "subject") {
            $query = "update lstul set subjectid = $id where subjectid = " . $in['subjectid'];
            $result = $conn->query($query);
            
            if (DB::isError($result)) {
                trigger_error("Error updating subject", E_USER_ERROR);
            }
            $in['subjectid'] = $id;
            header("Location: ChooseTopic.php?" . http_build_simple_query($in));
            exit();            
        }
        
        else if ($in['table'] == "topic") {
            $query = "update lstul set topicid = $id where topicid = " . $in['topicid'];
            $result = $conn->query($query);
            
            if (DB::isError($result)) {
                trigger_error("Error updating topic", E_USER_ERROR);
            }
            $in['topicid'] = $id;
            header("Location: ChooseUnit.php?" . http_build_simple_query($in));
            exit();            
        }
        
        else if ($in['table'] == "unit") {
            $query = "update lstul set unitid = $id where unitid = " . $in['unitid'];
            $result = $conn->query($query);
            
            if (DB::isError($result)) {
                trigger_error("Error updating unit", E_USER_ERROR);
            }
            $in['unitid'] = $id;
            header("Location: ChooseLesson.php?" . http_build_simple_query($in));
            exit();            
        }
    }
    
?>