<?php
    
    function layout_begin ()
    {
        layout_open();
        layout_open_header();
        layout_display_stylesheet();
        layout_display_javascript();
        layout_close_header();
        layout_display_banner();
        layout_open_cols();
        layout_display_left_col();
        layout_open_body();
        layout_display_page_title();
    }

    function layout_end ()
    {
        layout_close_body();
        layout_display_right_col();
        layout_close_cols();
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
        echo "<link rel='stylesheet' type='text/css' media='screen' href='{$config['local']['home']}Style/Default/Default.css'></script>\n";
        echo "<link rel='stylesheet' type='text/css' media='screen' href='{$config['local']['home']}Style/Default/Header.css'></script>\n";
        echo "<link rel='stylesheet' type='text/css' media='screen' href='{$config['local']['home']}Style/Default/Navigation.css'></script>\n";
    }

    function layout_display_javascript($javascripts = array()) 
    {
        global $config;
        echo "\n<!-- JavaScript -->\n";
        echo "<script language=\"JavaScript\" src=\"{$config['local']['home']}JavaScript/Navigation.js\"></script>\n";
    }

    function layout_display_banner()
    {
        global $config;

        echo "<!-- BEGIN BANNER -->\n";
        echo "<table class=header border=0 cellpadding=0 cellspacing=0 height=60 width=100%>\n";
        echo "  <tr>\n";
        echo "    <td align=left valign=middle>\n";
        echo "    <h1 class=header>". $config['site']['name'] . "</h1>";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "<!-- END BANNER -->\n";
    }

    function layout_open_cols()
    {
        echo "<!-- BEGIN COLUMNS -->\n";
        echo "<table border=0 cellpadding=0 cellspacing=4 width=100% border=1>\n";
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
        echo "    <td valign=top width={$config['layout']['left_col_width']}>\n";
        
        if (array_key_exists("navigation", $config) and $config['local']['name'] != "Login") {
            layout_navigation_box("Site Navigation", $config['navigation']);
        }
        echo "    <br>\n";
        
        if (array_key_exists("navigation", $config['local'])) {
            layout_navigation_box($config['local']['name'], $config['local']['navigation']);
        }
        echo "    <br>\n";
         
        if (array_key_exists("right_navigation", $config['local'])) {
            layout_navigation_box("Page Options", $config['local']['right_navigation']);
        }
        
        echo "    </td>\n";
        echo "<td width={$config['layout']['buffer_col_width']}>&nbsp;</td>\n";
        echo "<!-- END LEFT COLUMN -->\n";
    }

    function layout_display_right_col()
    {
    	global $config;
    	
        echo "<!-- BEGIN RIGHT COLUMN -->\n";
        echo "<td width={$config['layout']['buffer_col_width']}>&nbsp;</td>\n";
        echo "    <td valign=top width={$config['layout']['right_col_width']}>\n";
        if ($config['local']['name'] != "Login") {
            //layout_display_users_online();
        }
        
        echo "<br>\n";
        
        if ($config['local']['name'] != "Login") {
            //layout_display_quicklinks();
        }
        echo "    </td>\n";
        echo "<!-- END RIGHT COLUMN -->\n";
    }
    
    function layout_open_body()
    {
        echo "<!-- BEGIN BODY -->\n";
        echo "    <td valign=top>\n";
    }

    function layout_close_body()
    {
        echo "    </td>\n";
        echo "<!-- END BODY -->\n";
    }
    
    function layout_navigation_box($title, $links, $class = "Navigation")
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
            echo "<tr class='$class'>\n";
            echo "<td class='$class' nowrap \n";
            echo "    onMouseOver='NavigationMouseOver(this, \"" . jsEscape($name) . "\")'";
            echo "    onMouseOut='NavigationMouseOut(this)'";
            echo "    onClick='document.location = \"$link\";'\n>";
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
            echo "<td height=20>\n";
            echo "<a href=\"$link\" class=\"$class\">$name</a></td>\n";
            echo "</td>\n";
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
		echo "<table class=\"pagination_bar\">\n";
		echo "<tr>\n";
		echo "<td class=\"pagination_bar\" align=\"left\" width=\"33%\">\n";
		
		if (1 < $page_num) {
			$prev_page = $page_num - 1;
			echo "<form name=\"Previous Page\" action=\"$page\" method=\"GET\">\n";
			
            if (is_array($vars)) {
    			foreach ($vars as $key => $value) {
    				echo "<input type=hidden name=\"$key\" value=\"$value\">\n";
    			}
            }
			echo "<input type=hidden name=page_num value=\"$prev_page\">\n";
			echo "<input type=submit name=action value=\"&lt;&lt; Prev\">\n";
			echo "</form>\n";
		}
		echo "</td>\n";
		echo "<td class=\"pagination_bar\" align=\"center\" width=\"33%\">\n";
		
		
		if ($total_count <= $viewing_end) {
			$viewing_end = $total_count;
		}
        
        if ($viewing_end < $viewing_start) {
            $viewing_start = $viewing_end;
        }
        
		echo "viewing $viewing_start through $viewing_end of $total_count\n";
		echo "</td>\n";
		echo "<td class=\"pagination_bar\" align=\"right\" width=\"33%\">\n";
	
		if ($total_count > $viewing_end) {
			$next_page = $page_num + 1;
			echo "<form name=\"Previous Page\" action=\"$page\" method=\"GET\">\n";
			
            if (is_array($vars)) {
    			foreach ($vars as $key => $value) {
    				echo "<input type=hidden name=\"$key\" value=\"$value\">\n";
    			}
            }
			echo "<input type=hidden name=page_num value=\"$next_page\">\n";
			echo "<input type=submit name=action value=\"Next &gt;&gt;\">\n";
			echo "</form>\n";
		
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
        echo "    <h1 class=DialogBox>$prompt</h1>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td  class=DialogBox align=right><input type=submit name=action value='Yes'></td>\n";
        echo "    <td  class=DialogBox align=left><input type=submit name=action value='No'></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "</form>\n";
        layout_end();
    }
    
    function layout_archive_search_bar($action = "ViewVersions.php") {
        
        global $conn;
        global $config;
        $search = $config['local']['param']['search'];
        $appgroup = $config['local']['param']['appgroup'];
        
        echo "<table width=100%>\n";
        echo "<tr>\n";
        echo "<td width=50% align=left>\n";
        echo "<form action=\"{$action}\" method=\"GET\">\n";
        echo "<select name=\"appgroup\" onChange='this.form.submit()'>\n";
        echo "<option value=\"0\">View All</option>\n";

        $appgroup_sql = "select id, name from appgroup order by name";
        $appgroup_res = $conn->query($appgroup_sql);

        if (DB::isError($appgroup_res)) {
            print $query . "<br>";
            die("file: " . __FILE__ . "<br>line: " . __LINE__ . "<br>" . $appgroup_res->getMessage());
        }
        
        while ($appgroup_row = $appgroup_res->fetchRow(DB_FETCHMODE_OBJECT)) {
            echo "<option value=" . $appgroup_row->id;
            if ($appgroup_row->id == $appgroup) { 
                echo " selected"; 
            }
            echo ">";
            echo $appgroup_row->name;
            echo "</option>\n";
        }
        $appgroup_res->free();
        echo "</select>\n";
        echo "</td>\n";
        
        // Search Form
        echo "<td width=50% align=right>\n";
        echo "<input type=hidden name=screen value=\"View Versions\">\n";
        echo "<input type=text name=search value=\"{$search}\">\n";
        echo "<input type=submit name=action value=\"Search\">\n";
        echo "</form>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";  
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
        echo "<h1>" . $config['local']['title'] . "</h1>\n";
        //echo "</td></tr></table>";
    }
    
    function layout_display_icon_small($key, $attr = "") {
        global $config;
        
        if (! is_array($key)) {
            return;
        }
        
        if (array_key_exists($key, $config['icons'])) {
            echo "<img src=\"" . $config['icons'][$key] . "\" border=0 $attr align=middle width=22 height=20>";
        }
        else {
            echo "<img src=\"" . $config['icons']['default'] . "\" border=0 $attr align=middle width=22 height=20>";
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
    
    function layout_display_users_online () {
        global $config;
        global $conn;
        $users = array();
        
        $sql = "select uid, name
                  from {$config['session']['table']}  
                 where timestamp > CURRENT_TIMESTAMP - interval '{$config['session']['timeout']} seconds' 
                 order by timestamp";
                 
        $result = $conn->query($sql);
        echo "<!-- $sql -->\n\n";
        if (DB::isError($result)) {
            trigger_error("Could not get who is online: " . $sql, E_USER_NOTICE);
        }
        else {
            
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $users["i:Default User:" . $row['name']] = $config['local']['home'] . "Utils/ManageQuickLinks.php?uid=" . urlencode($row['uid']);
            }
            $result->free();
            layout_navigation_box("Users Online", $users);
        }
    }
    
    function layout_display_quicklinks () {
        global $config;
        global $conn;
        $links = array();
        
        $quid = $conn->quote($config['local']['user']['uid']);
        
        $sql = "select title, url
                  from {$config['quicklinks']['table']}
                 where uid = $quid order by timestamp";
                 
        $result = $conn->query($sql);
        echo "<!-- $sql -->\n\n";
        if (DB::isError($result)) {
            trigger_error("Could not get who is online: " . $sql, E_USER_NOTICE);
        }
        else {
            $links['Add to QuickLinks'] = $config['local']['home'] . "Utils/AddQuickLink.php?title=" . urlencode($config['local']['title']) . "&icon=" . urlencode($config['local']['name']) . "&home=" . urlencode($config['local']['home']) ;
            $links['Manage QuickLinks'] = $config['local']['home'] . "Utils/ManageQuickLinks.php";
            while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $links[$row['title']] = $config['local']['home'] . $row['url'];
            }
            $result->free();
            layout_navigation_box("QuickLinks", $links);
        }
    }

?>
