<?php
   
    define("NO_ANSWER", -1);
    define("NEW_ANSWER", -2);
    define("ADD_ANSWER", -3);
    
    define("TYPE_URL", 1);
    define("TYPE_LOCAL_FILE", 2);
    define("TYPE_FILE_PATH", 3);
    
    function get_level_navigation ()
    {
        global $conn;
        $return = array();
        
        $query = "select level.id as id, level.name as name 
                    from lstr 
                    join level on (id = levelid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get levels", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $return[$row['name']] = "ViewLevel.php?levelid=" . urlencode($row['id']);
        }
        return $return;
    }
    
    function curriculum_add_answer()
    {
        global $conn;
        
        $table = getUnescapedPost("table");
        $column = getUnescapedPost("column");
        $answer = getUnescapedPost("answer");
        
        if (!$table) {
            trigger_error("table is required", E_USER_ERROR);
        }
        
        if (!$column) {
            trigger_error("column is required", E_USER_ERROR);
        }
        
        if (!$answer) {
            trigger_error("answer is required", E_USER_ERROR);
        }
        
        $tableid = get_id_from_name($table, $column, $answer);
        
        if ($tableid > 0) {
            return $tableid;
        }
        
        $qtable = $conn->quote($table);
        $qcolumn = $conn->quote($column);
        $qanswer = $conn->quote($answer);    
        $query = "insert into $table ($column) values ($qanswer)";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to insert answer", E_USER_ERROR);
        }
        return db_get_insert_id($table . "_" . $column . "_seq");
    }
    
    function get_id_from_name($t, $c, $a) {
        global $conn;
        $qanswer = $conn->quote($a);
        $query = "select id from $t where $c = $qanswer";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve answer", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
    }
        
    
    function show_level_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=levelid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=levelid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select level.id as id, level.name as name 
                    from lstr 
                    join level on (id = levelid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get levels", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($levelid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function show_subject_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=subjectid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=subjectid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select subject.id as id, subject.name as name 
                    from lstr 
                    join subject on (id = subjectid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get subjects", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($subjectid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function show_topic_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER, $topicid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=topicid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=topicid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select topic.id as id, topic.name as name 
                    from lstr 
                    join topic on (id = topicid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get topics", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($topicid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function get_resource ($resourceid)
    {
        global $conn;
        $query = "select * from resource join lstr on (lstr.resourceid = resource.id) where id = " . $conn->quote($resourceid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get resource information.", E_USER_ERROR);
        }
        
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        $result->free();
        return $row;
    }

?>