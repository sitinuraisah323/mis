<?php
require_once 'Master.php';
class UnitsdailycashModel extends Master
{
	public $table = 'units_dailycashs';
	public $primary_key = 'id';


	public function get_unitsdailycash()
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,a.cash_code,a.amount,a.date,a.description,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units_dailycashs as a')->result();
	}

	public function get_transaksi_unit($area,$unit)
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,d.type,a.cash_code,a.amount,a.date,a.description,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->join('categories as d','d.id=a.id_category');		
		$this->db->where('b.id_area',$area);		
		$this->db->where('a.id_unit',$unit);		
		$this->db->order_by('a.date','asc');		
		return $this->db->get('units_dailycashs as a')->result();
	}



}
