<?php

    function http_build_simple_query($q)
    {
        $return = "";
        
        if (is_array($q)) {
        
            foreach ($q as $key => $value) {
                $return .= urlencode($key) . "=" . urlencode($value) . "&";
            }
        }
        else {
            trigger_error("http_build_simple_query not passed an array", E_USER_NOTICE);
        }
        return $return;
    }
            
?>