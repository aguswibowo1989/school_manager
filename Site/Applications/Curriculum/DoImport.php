<?php

    require("config.php");
    require("Archive/Tar.php");
    require("Applications/ImportParser.php");
    
    if ($_FILES['import']['error'] == 2) {
        trigger_error("File too large for upload", E_USER_ERROR);
    }
    else if ($_FILES['import']['error'] > 0) {
        trigger_error("Upload Error", E_USER_ERROR);
    }
    
    if (!$tar_obj = new Archive_Tar($_FILES['import']['tmp_name'])) {
        trigger_error("Could not open file", E_USER_ERROR);
    }  
    $xml_file = null; 

    if (($filelist  =  $tar_obj->listContent()) != 0) {
        for ($i=0; $i<sizeof($filelist); $i++) {
            if (substr($filelist[$i]['filename'], -4) == ".xml") {
                $xml_file = $filelist[$i]['filename'];
                if (! $tar_obj->extractList($filelist[$i]['filename'], 
                                $config['path']['filestore'] . "import\\")) {
                    trigger_error("Extract of MetaData Failed", E_USER_ERROR);
                }
            }
            else {
                if (! $tar_obj->extractList($filelist[$i]['filename'], 
                                            $config['path']['filestore'])) {
                    trigger_error("Extract of Resource Failed", E_USER_ERROR);
                }
            }
        }
    }
    else {
        trigger_error("Could not open file", E_USER_ERROR); 
    }
    
    layout_begin();
    show_breadcrumb();
    echo "<h1>Importing Lessons:</h1>\n";
    echo "<ul>\n";

    $p = &new ImportParser();
    $result = $p->setInputFile($config['path']['filestore'] . "import\\" . $xml_file);
    $result = $p->parse();
    
    if ($p->isError($result)) {
        trigger_error("Import Failed", E_USER_ERROR);
    }
    layout_end();

?>
