function NavigationMouseOver (form,name) {
	 window.status = name;
	 form.style.backgroundColor = '#000033';
	 form.style.cursor = 'pointer';
	 form.style.backgroundImage = "url(<?php echo $config['local']['common_images'] ?>nav_roll.gif)";
}

function NavigationMouseOut (form) {
	 window.status = '';
	 form.style.backgroundColor = '#A5AEBC';
	 form.style.backgroundImage = "";
}