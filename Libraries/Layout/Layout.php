<?php
    
    function layout_begin ()
    {
        layout_open();
        layout_open_header();
        layout_display_stylesheet();
        layout_display_javascript();
        layout_close_header();
        layout_open_cols();
        layout_display_left_col();
        layout_open_body();
        layout_display_page_title();
    }

    function layout_end ()
    {
        layout_close_body();
        layout_close_cols();
        layout_display_error_footer();
        layout_close();
    }

    function layout_open() 
    {
        echo "<html>\n";
    }

    function layout_close() 
    {
        echo "</body>\n";
        echo "</html>\n";
    }

    function layout_open_header() 
    {
        global $config;
        echo "<head>\n";
        echo "<title>{$config['local']['title']}</title>\n";
    }

    function layout_close_header() 
    {
        echo "</head>\n";
        echo "<body>\n";
    }

    function layout_display_stylesheet($stylesheets = array()) 
    {
        global $config;
        echo "\n<!-- StyleSheets -->\n";
        echo "<link rel='stylesheet' type='text/css' media='screen' href='{$config['local']['home']}Style/screen.css'></script>\n";
        echo "<link rel='stylesheet' type='text/css' media='print' href='{$config['local']['home']}Style/print.css'></script>\n";
    }

    function layout_display_javascript($javascripts = array()) 
    {
        global $config;
        echo "\n<!-- JavaScript -->\n";
        echo "<script language=\"JavaScript\" src=\"{$config['local']['home']}JavaScript/Navigation.js\"></script>\n";
        echo "<script language=\"JavaScript\" src=\"{$config['local']['home']}JavaScript/richtext.js\"></script>\n";
    }

    function layout_open_cols()
    {
        echo "<!-- BEGIN COLUMNS -->\n";
        echo "<table class=layout border=0 cellpadding=0 cellspacing=0>\n";
        echo "  <tr>\n";
    }

    function layout_close_cols()
    {
        echo "  </tr>\n";
        echo "</table>\n";
        echo "<!-- END COLUMNS -->\n";
    }

    function layout_display_left_col()
    {
        global $config;
        echo "<!-- BEGIN LEFT COLUMN -->\n";
        echo "    <td class=left-column valign=top>\n";
        
        if (array_key_exists("navigation", $config) and $config['local']['name'] != "Login") {
            layout_display_navigation_box($config['site']['name'], $config['navigation']);
        }
        
        if (array_key_exists("navigation", $config['local'])) {
            layout_display_navigation_box($config['local']['name'], $config['local']['navigation']);
        }
         
        if (array_key_exists("page_navigation", $config['local'])) {
            layout_display_navigation_box("Page Options", $config['local']['right_navigation']);
        }
        
        echo "    </td>\n";
        echo "<!-- END LEFT COLUMN -->\n";
    }
    
    function layout_open_body()
    {
        global $config;
        echo "<!-- BEGIN BODY -->\n";
        echo "    <td class=middle-column valign=top align=left>\n";
        echo "<div id=\"ContentArea\">\n";
    }

    function layout_close_body()
    {
        echo "    </div>\n";
        echo "    </td>\n";
        echo "<!-- END BODY -->\n";
    }
    
    function layout_display_navigation_box($title, $links, $class = "Navigation")
    {
        global $config;

        if (! $title || ! is_array($links)) {
            return;
        }

        echo "\n\n<!-- Begin Navigation Box $title -->\n";
        echo "<table class='$class' width=100%>\n";
        echo "<tr class='$class'>\n";
        echo "<th class='$class' nowrap height=20 valign=top>\n";
        
        if (substr($title, 0, 2) == "i:") {
            list($i, $icon, $title) = split(":", $title, 3);
            layout_display_icon_small($icon);
            echo "$title\n";
        }
        else {
            layout_display_icon_small($title, "align=right");
            echo "$title\n";
        }
        echo "</th></tr>\n";
                                               
        foreach ($links as $name => $link) {
            
            if ($name == $config['local']['name']) {
                echo "<tr class='{$class}_sel'>\n";
                echo "<td class='{$class}_sel' nowrap>\n";
            }
            else {
                echo "<tr class='$class'>\n";
                echo "<td class='$class' nowrap \n";
                echo "    onMouseOver='NavigationMouseOver(this, \"" . jsEscape($name) . "\")'";
                echo "    onMouseOut='NavigationMouseOut(this)'";
                echo "    onClick='document.location = \"$link\";'\n>";
            }
            
            echo "<table cellspacing=0 cellpadding=0 border=0 width=100%>\n";
            echo "<td width=22 height=20>\n";
            
            if (substr($name, 0, 2) == "i:") {
                list($i, $icon, $name) = split(":", $name, 3);
                layout_display_icon_small($icon);
            }
            else {
                layout_display_icon_small($name);
            }
        
            
            echo "</td>";
            
            if ($name == $config['local']['name']) {
                echo "<td class=\"{$class}_sel\">$name</td>\n";
            }
            else {
                echo "<td><a href=\"$link\" class=\"{$class}\">$name</a></td>";
            }
            
            echo "</tr>\n";
            echo "</table>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
        echo "<!-- End Navigation Box $title -->\n\n";

    }
    
    function layout_display_error($level, $message, $file, $line)
    {
    	echo "<table border=1 class=\"ErrorBox\" width=50% align=center>\n";
    	echo "  <tr>\n";
    	echo "    <td class=ErrorBox>\n";
    	echo "    <h2 class=ErrorBox>$message</h1>\n";
    	echo "    <h3 class=ErrorBox>File: $file</h2>\n";
    	echo "    <h3 class=ErrorBox>Line: $line</h2>\n";
    	echo "    <h3 class=ErrorBox>Level: $level</h2>\n";
    	echo "    </td>\n";
    	echo "   </tr>\n";
    	echo "</table>\n";	
    }
    
    function layout_display_pagnation_bar($page_num, $viewing_start, $viewing_end, $total_count, $page, $vars = array())
    {
		echo "<table class=\"pagination_bar\" border=1>\n";
		echo "<tr>\n";
		echo "<td class=\"pagination_bar\" valign=\"middle\" align=\"left\" width=\"33%\">\n";
		
		if (1 < $page_num) {
			$vars['page_num'] = $page_num - 1;
            echo "<a class=pagination_bar href=\"{$page}?" . http_build_simple_query($vars) . "\">&lt;&lt Prev</a>";
		}
		echo "</td>\n";
		echo "<td class=\"pagination_bar\" valign=\"middle\" align=\"center\" width=\"33%\">\n";
		
		
		if ($total_count <= $viewing_end) {
			$viewing_end = $total_count;
		}
        
        if ($viewing_end < $viewing_start) {
            $viewing_start = $viewing_end;
        }
        
		echo "viewing $viewing_start through $viewing_end of $total_count\n";
		echo "</td>\n";
		echo "<td class=\"pagination_bar\" valign=\"middle\" align=\"right\" width=\"33%\">\n";
	
		if ($total_count > $viewing_end) {
			$vars['page_num'] = $page_num + 1;
            echo "<a class=pagination_bar href=\"{$page}?" . http_build_simple_query($vars) . "\">Next &gt;&gt;</a>";
		
		}
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
    }
    	
    function layout_display_dialog ($prompt, $type = "YesNo", $vars = array())
    {
        layout_begin();
        echo "<form method=GET>\n";
        
        foreach ($vars as $key => $value) {
            echo "<input type=hidden name='$key' value='$value'>";
        }
        echo "<br>\n";
        echo "<br>\n";
        echo "<table border=0 cellpadding=10 class=\"DialogBox\" width=50% align=center>\n";
        echo "  <tr>\n";
        echo "    <td class=DialogBox colspan=2 align=center>\n";
        echo "    <h2 class=DialogBox>$prompt</h2>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        if ($type == "YesNo") {
            echo "    <td class=DialogBox align=right><input type=submit name=action value='Yes'></td>\n";
            echo "    <td class=DialogBox align=left><input type=submit name=action value='No'></td>\n";
        }
        else if ($type == "OK") {
            echo "    <td class=DialogBox align=right colspan=2><input type=submit name=action value='OK'></td>\n";
        }
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</form>\n";
        layout_end();
    }
    
    function layout_display_page_title() {
        global $config;
        
        // Look in Config/Layout.php for where this variable is set.
        if (in_array($config['local']['name'], $config['layout']['notitle'])) {
            return;
        }
        
        //echo "<table cellpadding=0 cellspacing=0 border=0 width=100%>\n";
        //echo "<tr><td>\n";
        //layout_display_icon_large($config['local']['name']);
        //echo "</td>\n";
        //echo "<td>\n";
        echo "<div id=title><h1>" . $config['local']['title'] . "</h1></diV>\n";
        //echo "</td></tr></table>";
    }
    
    function layout_display_icon_small($key, $attr = "") {
        global $config;
        
        if (! is_array($config['icons'])) {
            return;
        }
        
        if (array_key_exists($key, $config['icons'])) {
            echo "<img src=\"" . $config['icons'][$key] . "\" border=0 $attr align=middle width=24 height=24>";
        }
        else {
            echo "<img src=\"" . $config['icons']['default'] . "\" border=0 $attr align=middle width=24 height=24>";
        }
    }
    
    function layout_display_icon_large($key) {
        global $config;
        
        if (! is_array($key)) {
            return;
        }
        
        if (array_key_exists($key, $config['largeicons'])) {
            echo "<img src=\"" . $config['largeicons'][$key] . "\" border=0 align=bottom>";
        }
        else {
            echo "<img src=\"" . $config['largeicons']['default'] . "\" border=0 align=bottom>";
        }
    }

    function layout_display_error_footer()
    {
        global $config;
        
        if (! in_array('error', array_keys($config))) {
            return;
        }
        
        echo "<table border=1 class=\"ErrorFoot\" width=100% align=center cellpadding=5>\n";
        echo "<tr><th class=\"ErrorFoot\">Notices and Warnings</th></tr>\n";
        foreach ($config['error'] as $error) {
            echo "  <tr>\n";
            echo "    <td class=ErrorFoot>\n";
            echo $error['message'];
            echo "    </td>\n";
            echo "   </tr>\n";
        }
        echo "</table>\n";  
    }
?>
