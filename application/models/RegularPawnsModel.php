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

	public function creditToday($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
		->where('id_unit', $idUnit)
		->where('date_sbk', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		return (object)array(
			'mortage' => array(
				'noa'	=> (int) $noaMortages->noa,
				'up'	=> (int) $upaMortages->up,
			),
			'reguler'	=> array(
				'noa' =>  (int) $noaRegular->noa,
				'up' => (int) $upRegular->up 
			)	
		);
	}

	public function getCreditToday($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		return (object)array(
			'noa' => $noaMortages->noa + $noaRegular->noa,
			'up' => $upRegular->up + $upaMortages->up
		);
	}

	public function repaymentToday($idUnit, $today)
	{
		$data = $this->db->select('sum(money_loan) as up, count(*) as noa')->from('units_repayments')
			->where('id_unit', $idUnit)
			->where('date_repayment', $today)->get()->row();
		$cicilan = $this->db->select('count(*) as noa, sum(amount) as up')
					->from('units_repayments_mortage')
					->where('id_unit', $idUnit)
					->where('date_kredit', $today)
					->get()->row();				
		return (object)array(
			'mortage' => array(
				'noa'	=> (int) $cicilan->noa,
				'up'	=> (int) $cicilan->up,
			),
			'reguler'	=> array(
				'noa' => (int)$data->noa,
				'up' => (int)$data->up
			)
		);
	}

	public function getRepaymentToday($idUnit, $today)
	{
		$data = $this->db->select('sum(money_loan) as up, count(*) as noa')->from('units_repayments')
			->where('id_unit', $idUnit)
			->where('date_repayment', $today)->get()->row();
		$cicilan = $this->db->select('count(*) as noa, sum(amount) as up')
					->from('units_repayments_mortage')
					->where('id_unit', $idUnit)
					->where('date_kredit', $today)
					->get()->row();				
		return (object)array(
			'noa' => (int)$data->noa+$cicilan->noa,
			'up' => (int)$data->up+$cicilan->up,
		);
	}

	public function getUpByDate($idUnit, $date)
	{
		$upaMortages = (int) $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $date)->get()->row()->up;
		$up = (int) $this->db->select('sum(amount) as sum')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $date)
			->get()->row()->sum;
		return $up + $upaMortages;
	}

	public function getTotalDisburse($idUnit, $year = null, $month = null, $date = null)
	{

		if(!is_null($date)){
			$this->db->where('date_sbk',implode('-',array($year,zero_fill($month,2),$date)));
		}else{
			if(!is_null($year)){
				$this->db->where('YEAR(date_sbk)',$year);
			}
			if(!is_null($month)){
				$this->db->where('MONTH(date_sbk)',$month);
			}
		}
		//$date =22;$month =8;$year =2020;
		$dataMortage = $this->db->select('sum(amount_loan) as up, count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)->get()->row();
		$noaMortages = (int)$dataMortage->noa;
		$upMortages = (int)$dataMortage->up;
	   //var_dump($this->db->last_query());
	   //exit();

		if(!is_null($date)){
			$this->db->where('date_sbk',implode('-',array($year,$month,$date)));
		}else{
			if(!is_null($year)){
				$this->db->where('YEAR(date_sbk)',$year);
			}
			if(!is_null($month)){
				$this->db->where('MONTH(date_sbk)',$month);
			}
		}
		//$date =22;$month =8;$year =2020;
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

	public function getLastDateTransaction()
	{
		return $this->db->select('date_sbk as date')->from($this->table)
			->order_by('date_sbk', 'desc')
			->get()->row();
	}

	public function getLastDateTransactionUnit($idunit)
	{
		return $this->db->select('date_sbk as date')->from($this->table)
			->where('id_unit', $idunit)
			->order_by('date_sbk', 'desc')
			->get()->row();
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

	public function getSummaryRate($idUnit)
	{
		$summary = $this->db->select('sum(amount) as up,sum(capital_lease) as rate,MIN(capital_lease) as min_rate,Max(capital_lease) as max_rate,count(*) as noa')->from('units_regularpawns')
			->where('id_unit', $idUnit)
			->where('date_sbk IS NOT NULL')
			->where('status_transaction', 'N')->get()->row();
			//->where('date_sbk >=', $sdate)
			//->where('date_sbk <=', $endate)->get()->row();
		return (object)array(
			'up' => $summary->up,
			'rate' => (float)$summary->rate,
			'noa' => $summary->noa,
			'min_rate' => $summary->min_rate,
			'max_rate' => $summary->max_rate
		);
	}

	public function getSummaryRateUnits($idUnit)
	{
		$summaryRate =$this->db->select('sum(amount) as up,capital_lease as rate,sum(capital_lease) as tot_rate,count(*) as noa')->from('units_regularpawns')
				->where('date_sbk IS NOT NULL')
				->where('status_transaction', 'N')
				->where('id_unit', $idUnit)
				->group_by('capital_lease')
	  			->get()->result();
		return $summaryRate;
	}

	public function getSummaryUPUnits($idUnit)
	{
		$summaryUP =$this->db->select('sum(amount) as up,count(*) as total_noa')->from('units_regularpawns')
				->where('date_sbk IS NOT NULL')
				->where('status_transaction', 'N')
				->where('id_unit', $idUnit)
				  ->get()->row();
		
		return (object)array(
			'up' => $summaryUP->up,
			'tot_noa' => $summaryUP->total_noa
		);
	}

	public function getBooking($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		return (object)array(
			'noa_reg' 	 => $noaRegular->noa,
			'noa_nonreg' => $noaMortages->noa,
			'up_reg' 	 => $upRegular->up,
			'up_nonreg'  => $upaMortages->up
		);
	}

	public function getTransaction($idUnit, $today)
	{
		$noaRegular = $this->db->select('count(*) as noa')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$noaMortages = $this->db->select('count(*) as noa')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('date_sbk', $today)->get()->row();

		$upRepayRegular = $this->db->select('sum(money_loan) as up, count(*) as noa')->from('units_repayments')
			->where('id_unit', $idUnit)
			->where('date_repayment', $today)->get()->row();
		$upRepayMortage = $this->db->select('count(*) as noa, sum(amount) as up')
					->from('units_repayments_mortage')
					->where('id_unit', $idUnit)
					->where('date_kredit', $today)
					->get()->row();				
		return (object)array(
			'noa_pencairan' => (int) $noaMortages->noa + $noaRegular->noa,
			'up_pencairan' 	=> (int) $upRegular->up + $upaMortages->up,
			'noa_pelunasan' => (int)$upRepayMortage->noa + $upRepayMortage->noa,
			'up_pelunasan' 	=> (int)$upRepayRegular->up + $upRepayMortage->up
		);
	}

	public function getUnitCredit($idUnit, $month,$year)
	{
		$upRegular = $this->db->select('sum(amount) as up')->from($this->table)
			->where('id_unit', $idUnit)
			->where('MONTH(date_sbk)', $month)
			->where('YEAR(date_sbk)', $year)->get()->row();
		$upaMortages = $this->db->select('sum(amount_loan) as up')->from('units_mortages')
			->where('id_unit', $idUnit)
			->where('MONTH(date_sbk)', $month)
			->where('YEAR(date_sbk)', $year)->get()->row();

		return (object)array(
			'upRegular' => (int)$upRegular->up,
			'upMortage' => (int)$upaMortages->up,
			'up' => (int)$upRegular->up + (int)$upaMortages->up
		);
	}

	public function getUnitsRepayment($idUnit, $month,$year)
	{
		$Regular = $this->db->select('sum(money_loan) as up, count(*) as noa')->from('units_repayments')
			->where('id_unit', $idUnit)
			->where('MONTH(date_repayment)', $month)
			->where('YEAR(date_repayment)', $year)->get()->row();

		$Mortages = $this->db->select('distinct(date_kredit),amount')
					->from('units_repayments_mortage')
					->where('id_unit', $idUnit)
					->where('MONTH(date_kredit)', $month)
					->where('YEAR(date_kredit)', $year)
					->get()->result();
		$upMortage =0;
	    foreach ($Mortages as $Mortage) {
			$upMortage += $Mortage->amount; 
		}		
		$upMortage = $upMortage;	
		return (object)array(
			'upRegular' => (int) $Regular->up,
			'upMortage' => (int) $upMortage,
			'up' => (int)$Regular->up + (int)$upMortage
		);
	}

	public function unitMontly($idUnit, $month, $year)
	{
		$data = $this->db
				->select('count(*) noa, sum(amount) as up')
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

	public function getPendapatan($idUnit, $date, $method = '')
	{
		$this->load->model('MappingcaseModel', 'm_casing');	
		$data = $this->m_casing->get_list_pendapatan();
		$category=array();
		foreach ($data as $value) {
			array_push($category, $value->no_perk);
		}

		$this->db
		->select('sum(units_dailycashs.amount) as up')
		->join('units','units.id = units_dailycashs.id_unit')
		->where('units_dailycashs.id_unit', $idUnit)
		->where_in('units_dailycashs.no_perk', $category);
		if($method == 'daily'){
			$this->db->where('units_dailycashs.date',$date);
		}else{
			$this->db->where('units_dailycashs.date >=',date('Y-m-01', strtotime($date)));
			$this->db->where('units_dailycashs.date <=',$date);
		}
		return $this->db->get('units_dailycashs')->row();
	
	}

}
