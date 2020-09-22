<?php
require_once 'Master.php';
class MortagesModel extends Master
{
	public $table = 'units_mortages';

	public $primary_key = 'id';
	
	public $level = true;

	public function unitMontly($idUnit, $month, $year)
	{
		$data = $this->db
				->select('count(*) noa, sum(amount_loan) as up')
				->from($this->table)
				->where('id_unit', $idUnit)
				->where('MONTH(date_sbk)', $month)
				->where('YEAR(date_sbk)', $year)
				->get()->row();
	
		return (object) array(
			'up'	=> (int) $data->up,
			'noa'	=> (int) $data->noa
		);
	}
	
	
}
