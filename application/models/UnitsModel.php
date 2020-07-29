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

	public function get_units_byarea($area)
	{
		$this->db->select('a.id,b.area,a.name');		
		$this->db->join('areas as b','b.id=a.id_area');		
		$this->db->where('a.id_area',$area);		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units as a')->result();
	}

	public function get_units_cicilan_byarea($area)
	{
		$this->db->select('DISTINCT(units.id),areas.id,units.name');		
		$this->db->join('units ','units_mortages.id_unit=units.id');		
		$this->db->join('areas ','units.id_area=areas.id');		
		$this->db->where('areas.id',$area);		
		$this->db->order_by('units.id','desc');		
		return $this->db->get('units_mortages')->result();
	}

	public function get_customers_gadaireguler_byunit($unit)
	{
		$this->db->distinct();
		$this->db->select('b.nik,b.name');		
		$this->db->join('customers as b','b.id=a.id_customer');		
		$this->db->where('a.id_unit',$unit);		
		$this->db->order_by('b.name','asc');		
		return $this->db->get('units_regularpawns as a')->result();
	}

	public function get_customers_gadaicicilan_byunit($unit)
	{
		$this->db->distinct();
		$this->db->select('a.id_customer,b.nik,b.name');		
		$this->db->join('customers as b','b.id=a.id_customer');		
		$this->db->where('a.id_unit',$unit);		
		$this->db->order_by('b.name','asc');		
		return $this->db->get('units_mortages as a')->result();
	}


}
