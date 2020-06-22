<?php
require_once 'Master.php';
class UnitstargetModel extends Master
{
	public $table = 'units_targets';
	public $primary_key = 'id';


	public function get_unitstarget()
	{
		$this->db->select('a.id,b.name,b.id_area,c.area,a.month,a.year,a.amount,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('area as c','c.id=b.id_id_area');		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units_targets as a')->result();
	}

}
