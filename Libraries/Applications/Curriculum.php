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
                    from lstul 
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
    
    function curriculum_add_answer($table, $column, $answer)
    {
        global $conn;
        
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

    function get_lessonid_from_resourceid($resourceid) {
        global $conn;
        $query = "select lessonid from lesson_resource where resourceid = " . $conn->quote($resourceid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve lessonid", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
    }
    
    function get_lessonid_from_testbankid($testbankid) {
        global $conn;
        $query = "select lessonid from lesson_testbank where testbankid = " . $conn->quote($testbankid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve testbankid", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
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
    
    function get_name_from_id($t, $c, $a) {
        global $conn;
        
        if ($a == "" || $a == -1) {
            return "";
        }
        $qanswer = $conn->quote($a);
        $query = "select name from $t where $c = $qanswer";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve answer", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return "";
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
                    from lstul 
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
                    from lstul 
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
                    from lstul 
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
    
    function show_unit_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER, $topicid = NO_ANSWER, $unitid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=unitid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=unitid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select unit.id as id, unit.name as name 
                    from lstul 
                    join unit on (id = unitid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get units", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($unitid == $row['id']) {
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
        $query = "select * from resource where id = " . $conn->quote($resourceid);
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
    
    function get_testquestion ($testbankid)
    {
        global $conn;
        $query = "select * from testbank where id = " . $conn->quote($testbankid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get test question information.", E_USER_ERROR);
        }
        
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        $result->free();
        return $row;
    }
    
    function get_lesson ($lessonid)
    {
        global $conn;
        $query = "select name, author, school, description, levelid, topicid, subjectid, unitid, date_format(lstul.timestamp, '%c/%e/%Y %r') as t from lesson join lstul on (lstul.lessonid = lesson.id) where id = " . $conn->quote($lessonid);
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

    function show_breadcrumb_lesson ($lessonid = -1)
    {

        if ($lessonid == -1) {
            return;
        }

        $lesson = get_lesson($lessonid);
        show_breadcrumb($lesson['levelid'], $lesson['subjectid'], $lesson['topicid'],
                        $lesson['unitid']);

    }
    
    function show_breadcrumb ($levelid = -1, $subjectid = -1, $topicid = -1, $unitid = -1)
    {
        $level_name = get_name_from_id("level", "id", $levelid);
        $subject_name = get_name_from_id("subject", "id", $subjectid);
        $topic_name = get_name_from_id("topic", "id", $topicid);
        $unit_name = get_name_from_id("unit", "id", $unitid);

        echo "<div id=breadcrumb>"; 
        echo "<a href=\"ChooseLevel.php\">Lesson Plans</a>";
        
        // Show Level
        if ($level_name) {
           
            $var['levelid'] = $levelid;
            echo " &gt; "; 
            echo "<a href=\"ChooseSubject.php? " . http_build_simple_query($var) . "\">" . $level_name . "</a>";
            
            // Show Subject
            if ($subject_name) {
                $var['subjectid'] = $subjectid;
                echo " &gt; ";               
                echo "<a href=\"ChooseTopic.php? " . http_build_simple_query($var) . "\">" . $subject_name . "</a>";
            
                // Show Topic
                if ($topic_name) {
                    $var['topicid'] = $topicid;
                    echo " &gt; ";
                    echo "<a href=\"ChooseUnit.php? " . http_build_simple_query($var) . "\">" . $topic_name . "</a>";
               
                    // Show Unit
                    if ($unit_name) {
                        $var['unitid'] = $unitid;
                        echo " &gt; ";
                        echo "<a href=\"ChooseLesson.php? " . http_build_simple_query($var) . "\">" . $unit_name . "</a>";
                    } 
                }
            }
        }
        echo "</div>";   
    }

    function RTESafe($strText) {
        //returns safe code for preloading in the RTE
        $tmpString = trim($strText);
        
        //convert all types of single quotes
        $tmpString = str_replace(chr(145), chr(39), $tmpString);
        $tmpString = str_replace(chr(146), chr(39), $tmpString);
        $tmpString = str_replace("'", "&#39;", $tmpString);
        
        //convert all types of double quotes
        $tmpString = str_replace(chr(147), chr(34), $tmpString);
        $tmpString = str_replace(chr(148), chr(34), $tmpString);
//    	$tmpString = str_replace("\"", "\"", $tmpString);
        
        //replace carriage returns & line feeds
        $tmpString = str_replace(chr(10), " ", $tmpString);
        $tmpString = str_replace(chr(13), " ", $tmpString);
        
        return $tmpString;
    }

?>
