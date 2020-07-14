<?php
require_once 'Master.php';
class RepaymentmortageModel extends Master
{
	public $table = 'units_repayments_mortage';
	public $primary_key = 'id';


	public function get_repaymentsmortage($nosbk,$unit)
	{
		$this->db->select('*');		
		$this->db->where('a.no_sbk',$nosbk);		
		$this->db->where('a.id_unit',$unit);		
		return $this->db->get('units_repayments_mortage as a')->result();
	}

}
