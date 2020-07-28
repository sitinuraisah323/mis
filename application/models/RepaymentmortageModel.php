<?php
require_once 'Master.php';
class RepaymentmortageModel extends Master
{
	public $table = 'units_repayments_mortage';
	public $primary_key = 'id';


	public function get_repaymentsmortage($nosbk,$unit)
	{
		$this->db->select('*,units_repayments_mortage.capital_lease as sewa_modal');		
		$this->db->join('units_mortages','units_repayments_mortage.no_sbk=units_mortages.no_sbk');		
		$this->db->where('units_repayments_mortage.no_sbk',$nosbk);		
		$this->db->where('units_repayments_mortage.id_unit',$unit);		
		return $this->db->get('units_repayments_mortage')->result();
	}

}