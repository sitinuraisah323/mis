<?php
require_once 'Master.php';
class MortagesSummaryModel extends Master
{
	public $table = 'units_mortages_summary';
	public $primary_key = 'id';

	public function get_mortagessummary($idUnit,$no_sbk){
		$this->db->select('*')->from($this->table)
				->where('id_unit', $idUnit)
				->where('no_sbk', $no_sbk);
		return	$this->db->get()->result();
	}

}


