function NavigationMouseOver (form,name) {
	window.status = name;
	form.style.backgroundColor = '#ebebeb';
	form.style.cursor = 'pointer';
	form.style.backgroundImage = "url(<?php echo $config['local']['common_images'] ?>nav_roll.gif)";
}

function NavigationMouseOut (form) {
	window.status = '';
	form.style.backgroundColor = '#cbcbcb';
	form.style.backgroundImage = "";
}