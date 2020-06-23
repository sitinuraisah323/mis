<?php
require_once 'Master.php';
class RepaymentModel extends Master
{
	public $table = 'units_repayments';
	public $primary_key = 'id';


	public function get_unitsdailycash()
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,a.type,a.cash_code,a.amount,a.date,a.description,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->order_by('a.id','desc');		
		return $this->db->get('units_repayments as a')->result();
	}

}
