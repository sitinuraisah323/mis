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

if (! function_exists('export_csv')){
    function export_csv($arr,$field){
		 //output headers so that the file is downloaded rather than displayed
		 //header("Content-type: application/octet-stream");
		 header('Content-Type: text/csv');
		 header('Content-Disposition: attachment; filename="export.csv"');

         $output = fopen('php://output', 'w');          
         fputcsv($output,$field);          
         foreach ($arr as $row) {
             fputcsv($output, $row);
         }
         return $output;
    }
}
