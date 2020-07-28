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
    function export_csv($arr){
		 //output headers so that the file is downloaded rather than displayed
		 //header("Content-type: application/octet-stream");
         //header('Content-Type: text/csv; charset=utf-8');
		 //header('Content-Disposition: attachment; filename=export_data.csv');
		 //header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		 //header("Content-Disposition: attachment; filename=abc.xls"); 
		 
		//  header("Content-Description: File Transfer");
		//  header("Content-Disposition: attachment; filename=export_data.csv");
		//  header("Content-Type: application/csv; ");

		 header('Content-Type: text/csv');
		 header('Content-Disposition: attachment; filename="export.csv"');
		 header('Pragma: no-cache');
		 header('Expires: 0');

         $output = fopen('php://output', 'w');          
         fputcsv($output);          
         foreach ($arr as $row) {
             fputcsv($output, $row);
         }
         return $output;
    }
}
