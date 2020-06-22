<?php
require_once 'Master.php';
class UnitsModel extends Master
{
	public $table = 'units';
	public $primary_key = 'id';


	public function get_units()
	{
		$this->db->select('a.id,b.area,a.name,a.code,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('areas as b','b.id=a.id_area');		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units as a')->result();
	}

}
