<?php
require_once 'Master.php';
class LmTransactionsModel extends Master
{
	public $table = 'lm_transactions';
	public $primary_key = 'id';

	public function sales($idArea, $idUnit, $dateStart, $dateEnd) 
	{
		if($idUnit > 0){
			$this->db->where('lm_transactions.id_unit', $idUnit);
		}
		if($idArea > 0){
			$this->db->where('units.id_area', $idArea);
		}
		$this->db->select('units.name as unit, date, series.series, 
		lm_transactions.name as pembeli, lm_transactions_grams.*, lm_transactions.id_employee')
				->from('lm_transactions_grams')
				->join('lm_transactions','lm_transactions.id = lm_transactions_grams.id_lm_transaction')
				->join('series','series.id = lm_transactions_grams.id_series')
				->join('units','units.id = lm_transactions.id_unit')
				->where('lm_transactions.date >=', $dateStart)
				->where('lm_transactions.date <=', $dateEnd)
				->where('lm_transactions.type_transaction','SALE');
		$sales = $this->db->get()->result();

		if($sales){
			foreach($sales as $sale){
				if($sale->id_employee !== 0){
					$employee = $this->db
						->select('fullname')
						->where('id', $sale->id_employee)
						->get('employees')->row();
					if($employee){
						$sale->pembeli = $employee->fullname;
					}
				}
			}
		}

		return $sales;
	}
}
