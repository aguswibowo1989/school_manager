<?php

    require_once("XML/Parser.php");
    
    class ImportParser extends XML_Parser
    {
        var $lesson_queue;
        var $current_index;
        var $current_tag;

      
        function ImportParser()
        {
          $lesson_queue = array();
          $current_tag =  0;
          parent::XML_Parser();
        }
      
        /**
         * handle start element
         *
         * @access private
         * @param  resource  xml parser resource
         * @param  string    name of the element
         * @param  array     attributes
         */
        function startHandler($xp, $name, $attribs)
        {
            if (strtoupper($name) == "LESSON") {
                $this->current_index = 0;
                $this->lesson_queue = array();
                $this->lesson_queue[$this->current_index] = 
                    array("data_type" => "lesson",
                          "LEVEL" => "",
                          "SUBJECT" => "",
                          "UNIT" => "",
                          "TOPIC" => "",
                          "NAME" => "",
                          "DESCRIPTION" => "",
                          "AUTHOR" => "",
                          "SCHOOL" => "",
                          "CREATED" => "",
                          "UID" => "");
            }
            
            else if (strtoupper($name) == "RESOURCE") {
                $this->current_index++;
                $this->lesson_queue[$this->current_index] = 
                    array("data_type" => "resource",
                          "NAME" => "",
                          "PATH" => "",
                          "DESCRIPTION" => "",
                          "TYPE" => "",
                          "MIMETYPE" => "",
                          "MD5" => "",
                          "TIMESTAMP" => "",
                          "UID" => "");
            }
            
            else if (strtoupper($name) == "TESTBANK") {
                $this->current_index++;
                $this->lesson_queue[$this->current_index] = 
                    array("data_type" => "testbank",
                          "QUESTION" => "",
                          "ANSWER" => "",
                          "TIMESTAMP" => "");
            }

            $this->current_tag = strtoupper($name);

        }
        
        /**
         * handle start element
         *
         * @access private
         * @param  resource  xml parser resource
         * @param  string    name of the element
         */
        function endHandler($xp, $name)
        {
            if (strtoupper($name) == "LESSON") {
                import_lesson_from_xml($this->lesson_queue);
            }
        }
        
        function cdataHandler($xp, $data)
        {
            if (strlen($data) == 0) {
                return NULL;
            }
            
            if (in_array($this->current_tag,
                         array("EXPORT", "LESSON", "TESTBANK", "RESOURCE"))) {
                return NULL;
            }

            $this->lesson_queue[$this->current_index][$this->current_tag] .= $data;
        }
    }

?>
