<?php
require_once 'Master.php';
class UnitstargetModel extends Master
{
	public $table = 'units_targets';
	public $primary_key = 'id';


	public function get_unitstarget()
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,a.month,a.year,a.amount_booking,a.amount_outstanding,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units_targets as a')->result();
	}

	public function get_byid($id)
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,a.month,a.year,a.amount_booking,a.amount_outstanding,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->where('a.id',$id);		
		return $this->db->get('units_targets as a')->row();
	}

	public function get_sum_targetbooking_requler($startdate,$enddate,$unit)
	{
		$this->db->select('SUM(amount) as up');		
		$this->db->where('date_sbk >=',$startdate);		
		$this->db->where('date_sbk<=',$enddate);		
		$this->db->where('id_unit ',$unit);		
		return $this->db->get('units_regularpawns')->row();
	}

	public function get_sum_targetbooking_cicilan($startdate,$enddate,$unit)
	{
		$this->db->select('SUM(amount_loan) as up');		
		$this->db->where('date_sbk >=',$startdate);		
		$this->db->where('date_sbk<=',$enddate);
		$this->db->where('id_unit ',$unit);			
		return $this->db->get('units_mortages')->row();
	}

	public function get_sum_targetoutstanding_requler($startdate,$enddate,$unit)
	{
		$this->db->select('SUM(amount) as up');		
		$this->db->where('date_sbk >=',$startdate);		
		$this->db->where('date_sbk<=',$enddate);		
		$this->db->where('status_transaction ','N');	
		$this->db->where('id_unit ',$unit);		
		return $this->db->get('units_regularpawns')->row();
	}

	public function get_sum_targetoutstanding_cicilan($startdate,$enddate,$unit)
	{
		$this->db->select('SUM(amount) as up');		
		$this->db->join('units_repayments_mortage ','units_mortages.no_sbk = units_repayments_mortage.no_sbk');		
		$this->db->where('units_mortages.status_transaction ','N');		
		$this->db->where('units_repayments_mortage.date_kredit >=',$startdate);		
		$this->db->where('units_repayments_mortage.date_kredit<=',$enddate);
		$this->db->where('units_mortages.id_unit ',$unit);			
		return $this->db->get('units_mortages')->row();
	}

}
