<?php

    require("config.php");
    layout_begin();
    
?>
<h2> Welcome to SchoolManager </h2>

<p>This site aims to help teachers to organize and share lesson plans.  Use the
<a href="<?= $config['local']['home'] ?>Applications/Curriculum/">Curriculum</a>
Section of this application to start create lesson plans in this tool.</p>

<?php 
    
    layout_end();

?>
