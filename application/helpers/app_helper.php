<?php
function zero_fill($number, $width){
	return str_pad((string)$number, $width, "0", STR_PAD_LEFT);
}
