<?php
function zero_fill($number, $width){
	return str_pad((string)$number, $width, "0", STR_PAD_LEFT);
}

function read_access($menu = null){
	if($privileges = $_SESSION['privileges']) {
		if($segments = explode('/',$menu)){
			foreach ($segments as $index => $segment){
				if(key_exists($index,$privileges)){
					if(key_exists($segment, $privileges[$index])){
						if($privileges[$index][strtolower($segment)] == 'DENIED'){
							return false;
						}
					}
				}
			}
		}
	}
	return true;
}


function write_access($menu = null){
	if($privileges = $_SESSION['privileges']) {
		if($segments = explode('/',$menu)){
			foreach ($segments as $index => $segment){
				if(key_exists($index,$privileges)){
					if(key_exists(strtolower($segment), $privileges[$index])){
						if($privileges[$index][strtolower($segment)] != 'WRITE'){
							return false;
						}
					}
				}
			}
		}
	}
	return true;
}
