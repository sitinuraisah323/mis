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
		$bapkas = $this->db->select('os_unit')->from('units_cash_book')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

		$outstanding = $this->db->select('os')->from('units_outstanding')
			->where('id_unit', $idUnit)
			->where('date', $date)->get()->row();

			return (object)array(
				'os_unit' =>(int) $bapkas->os_unit,
				'os' => (int) $outstanding->os
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

}
