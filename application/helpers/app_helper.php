<?php
function zero_fill($number, $width){
	return str_pad((string)$number, $width, "0", STR_PAD_LEFT);
}

function read_access($menu = null){
	if($privileges = $_SESSION['privileges']) {
		if (array_key_exists($menu, $privileges)) {
			$privilege = $privileges[$menu];
			if ($privilege == 'DENIED') {
				return false;
			}
		}
	}
	return true;
}


function write_access($menu){
	if($privileges = $_SESSION['privileges']) {
		if (array_key_exists($menu, $privileges)) {
			$privilege = $privileges[$menu];
			if ($privilege != 'WRITE') {
				return false;
			}
		}
	}
	return true;
}
