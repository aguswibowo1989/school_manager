<?php 

	require("config.php");
	
	layout_begin();

?> 
<br>
<br>
<form name="LoginForm" action="Login.php" method="POST">

<input type="hidden" name="url" value="<?php echo $_GET['url'] ?>">
<table align=center background=<?php echo $config['local']['common_images'] ?>white_login.gif>
<tr>
<th height=30px colspan=2></th>
</tr>
<tr>
<td width=80px></td>
<td><input type="text" name="username" value="" size="30" maxlength="40"/></td>
</tr>
<tr>
<td width=80px></td>
<td width=263px><input type="password" name="password" size="30" maxlength="40"/></td>
</tr>  
<tr>
<td colspan=2 align=center><input type="image"
 SRC="<?php echo $config['local']['common_images'] ?>enter_button.gif" WIDTH=81 HEIGHT=27 ALT="
name="action" value="enter"/></td>
</tr>  
</table>
</form>  


<?php
	layout_end();
?>