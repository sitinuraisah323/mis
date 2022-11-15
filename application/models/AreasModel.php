<?php
require_once 'Master.php';
class AreasModel extends Master
{
	public $table = 'areas';
	public $primary_key = 'id';

	public function get_area()
	{
		$this->db->select('a.id,a.area, a.area_id');
		$this->db->order_by('a.id','desc');		
		return $this->db->get('areas as a')->result();
	}
}


