<?php
error_reporting(0);
require_once 'Master.php';
class BookCashModel extends Master
{
	public $table = 'units_cash_book';

	public $primary_key = 'id';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('BookCashMoneyModel','money');
	}	

	public function getbapkas($idUnit, $date)
	{
		$bapkas = $this->db->select('os_unit,os_cicilan')->from('units_cash_book')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

		$outstanding = $this->db->select('os,os_real_reguler,os_real_mortage,real_outstanding')->from('units_outstanding')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

			return (object)array(
				'os_unit' 			=>(int) $bapkas->os_unit,
				'os_cicilan' 		=>(int) $bapkas->os_cicilan,
				'os_bap' 			=>(int) $bapkas->os_unit + (int) $bapkas->os_cicilan,
				'os' 			  	=> (int) $outstanding->os,
				'os_real_regular' 	=> (int) $outstanding->os_real_reguler,
				'os_real_mortage' 	=> (int) $outstanding->os_real_mortage,
				'os_real' 			=> (int) $outstanding->real_outstanding,
			);
	}

	public function getbapsaldo($idUnit, $date)
	{
		$bapkas = $this->db->select('amount_balance_final')->from('units_cash_book')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

		$outstanding = $this->db->select('os')->from('units_outstanding')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

			return (object)array(
				'bapsaldo' =>(int) $bapkas->amount_balance_final,
				'kassaldo' => (int) $outstanding->os
			);
	}

	public function getUnitBapKas($idUnit, $date)
	{
		$bapkas = $this->db->select('*')->from('units_cash_book')
			->where('units_cash_book.id_unit', $idUnit)
			->where('date', $date)->get()->row();
			return $bapkas;
	}

	public function getUnitPaguKas($idUnit, $date)
	{
		$bapkas = $this->db->select('*')
			->from('units_cash_book')
			->join('units_setting','units_setting.id_unit=units_cash_book.id_unit')
			->where('units_cash_book.id_unit', $idUnit)
			->where('date', $date)->get()->row();
			return $bapkas;
	}

}