<?php
require_once 'Master.php';
class RegularpawnsModel extends Master
{
	public $table = 'units_regularpawns';

	public $level = true;

	public $primary_key = 'id';

	public function getOstYesterday($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();
		return (object)array(
			'noa' => $noaMortages->noa + $noaRegular->noa,
			'up' => $upRegular->up + $upaMortages->up
		);
	}

	public function getCreditToday($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk', $today)->get()->row();

		return (object)array(
			'noa' => $noaMortages->noa + $noaRegular->noa,
			'up' => $upRegular->up + $upaMortages->up
		);
	}

	public function getRepaymentToday($idUnit, $today)
	{
		$data = $this->db->select('sum(money_loan) as up, count(*) as noa')->from('units_repayments')
			->where('id_unit', $idUnit)
			->where('date_repayment', $today)->get()->row();
		return (object)array(
			'noa' => (int)$data->noa,
			'up' => (int)$data->up,
		);
	}

	public function getUpByDate($idUnit, $date)
	{
		return (int) $this->db->select('sum(amount) as sum')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $date)
			->get()->row()->sum;
	}

	public function getTotalDisburse($idUnit, $year = null, $month = null, $date = null)
	{

		if(!is_null($date)){
			$this->db->where('date_sbk <=',implode('-',array($year,$month,$date)));
		}else{
			if(!is_null($year)){
				$this->db->where('YEAR(date_sbk)',$year);
			}
			if(!is_null($month)){
				$this->db->where('MONTH(date_sbk)',$month);
			}
		}
		$dataMortage = $this->db->select('sum(amount_loan) as up, count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)->get()->row();
		$noaMortages = (int)$dataMortage->noa;
		$upMortages = (int)$dataMortage->up;


		if(!is_null($date)){
			$this->db->where('date_sbk <=',implode('-',array($year,$month,$date)));
		}else{
			if(!is_null($year)){
				$this->db->where('YEAR(date_sbk)',$year);
			}
			if(!is_null($month)){
				$this->db->where('MONTH(date_sbk)',$month);
			}
		}

		$dataRegular = $this->db->select('sum(amount) as up, count(*) as noa')->from('units_regularpawns')
			->where('id_unit', $idUnit)->get()->row();
		$noaRegular = (int)$dataRegular->noa;
		$upRegular = (int)$dataRegular->up;

		return (object)array(
			'noa' => (int)$noaMortages + $noaRegular,
			'credit' => (int)$upMortages + $upRegular,
			'tiket' => (int)$upMortages + $upRegular > 0 ? ($upMortages + $upRegular) / ($noaMortages + $noaRegular) : 0,
		);
	}

	public function getDpdYesterday($idUnit, $date)
	{
		$data = $this->db->select('sum(amount) as ost, count(*) as noa')
			->from($this->table)
			->where('status_transaction', 'N')
			->where('deadline <', $date)
			->where('id_unit', $idUnit)
			->get()->row();
		return (object)array(
			'noa' => (int)$data->noa,
			'ost' => (int)$data->ost,
		);
	}

	public function getDpdToday($idUnit, $date)
	{
		$data = $this->db->select('sum(amount) as ost, count(*) as noa')
			->from($this->table)
			->where('status_transaction', 'N')
			->where('id_unit', $idUnit)
			->where('deadline', $date)
			->get()->row();
		return (object)array(
			'noa' => (int)$data->noa,
			'ost' => (int)$data->ost,
		);
	}

	public function getDpdRepaymentToday($idUnit, $date)
	{
		$data = $this->db->select('sum(units_regularpawns.amount) as ost, count(*) as noa')
			->from($this->table)
			->join('units_repayments','units_repayments.no_sbk = '.$this->table.'.no_sbk')
			->where('units_repayments.id_unit', $idUnit)
			->where($this->table.'.id_unit', $idUnit)
			->where($this->table.'.status_transaction', 'N')
			->where('units_repayments.date_repayment', $date)
			->get()->row();
		return (object)array(
			'noa' => (int) $data->noa,
			'ost' => (int) $data->ost,
		);
	}

	public function getOstYesterday_($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <', $today)->get()->row();
		return (object)array(
			'noa' => (int) $noaRegular->noa,
			'up' => (int) $upRegular->up
		);
	}

	public function getOstToday_($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <=', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <=', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <=', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('status_transaction', 'N')
			->where('date_sbk <=', $today)->get()->row();

		return (object)array(
			'noa' => (int)$noaRegular->noa,
			'up' => (int)$upRegular->up,
			'm_noa' => (int)$noaMortages->noa,
			'm_up' => (int)$upaMortages->up
		);
	}

}
