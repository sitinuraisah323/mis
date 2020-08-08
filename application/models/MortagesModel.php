<?php
require_once 'Master.php';
class MortagesModel extends Master
{
	public $table = 'units_mortages';

	public $primary_key = 'id';
	
	public $level = true;
	
}
