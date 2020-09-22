<?php
require_once 'Master.php';
class UnitsdailycashModel extends Master
{
	public $table = 'units_dailycashs';
	public $primary_key = 'id';
	public $level = true;


	public function get_unitsdailycash()
	{
		$this->db->select('units_dailycashs.id,b.id as id_unit,b.name,b.id_area,c.area,units_dailycashs.cash_code,units_dailycashs.amount,units_dailycashs.date,units_dailycashs.description,units_dailycashs.status,units_dailycashs.date_create,units_dailycashs.date_update,units_dailycashs.user_create,units_dailycashs.user_update');		
		$this->db->join('units as b','b.id=units_dailycashs.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->order_by('units_dailycashs.id','desc');		
		return $this->all();
	}

	public function get_transaksi_unit($area,$unit)
	{
		$this->db->select('a.id,b.id as id_unit,b.name,b.id_area,c.area,d.type,a.cash_code,a.amount,a.date,a.description,a.status,a.date_create,a.date_update,a.user_create,a.user_update');		
		$this->db->join('units as b','b.id=a.id_unit');		
		$this->db->join('areas as c','c.id=b.id_area');		
		$this->db->join('categories as d','d.id=a.id_category');		
		$this->db->where('b.id_area',$area);		
		$this->db->where('a.id_unit',$unit);		
		$this->db->order_by('a.date','asc');		
		return $this->db->get('units_dailycashs as a')->result();
	}

	public function getSummaryCashin($startdate,$endate,$perk,$idUnit)
	{
		$data = $this->db->select('sum(amount) as amount, count(*) as total')->from('units_dailycashs')
			->where('type =', 'CASH_IN')
			->where('date >=', $startdate)
			->where('date <=', $endate)
			->where('no_perk ', $perk)
			->where('id_unit', $idUnit)->get()->row();
		return (object)array(
			'amount' => (int)$data->amount,
			'total' => (int)$data->total,
		);
	}

	public function getSaldo($idUnit,$date)
	{
		$saldo = $this->units->db->select('amount,cut_off')
					->from('units_saldo')
					->where('units_saldo.id_unit', $idUnit)
					->get()->row();

		$cashin = $this->units->db->select('sum(amount) as amount')
					->from('units_dailycashs')
					->where('units_dailycashs.type','CASH_IN')
					->where('units_dailycashs.id_unit', $idUnit)
					->where('units_dailycashs.date >',$saldo->cut_off)
					->where('units_dailycashs.date <=',$date)
					->get()->row();

		
		$cashout = $this->units->db->select('sum(amount) as amount')
					->from('units_dailycashs')
					->where('units_dailycashs.type','CASH_OUT')
					->where('units_dailycashs.id_unit', $idUnit)
					->where('units_dailycashs.date >',$saldo->cut_off)
					->where('units_dailycashs.date <=',$date)
					->get()->row();

		return (object)array(
			'cashin' => (int)$cashin->amount,
			'cashout' => (int)$cashout->amount,
			'saldo' => (int)($saldo->amount+$cashin->amount) - $cashout->amount
		);
	}

	public function getSaldoYestrday($idUnit,$date)
	{
		$saldo = $this->units->db->select('amount,cut_off')
					->from('units_saldo')
					->where('units_saldo.id_unit', $idUnit)
					->get()->row();

		$cashin = $this->units->db->select('sum(amount) as amount')
					->from('units_dailycashs')
					->where('units_dailycashs.type','CASH_IN')
					->where('units_dailycashs.id_unit', $idUnit)
					->where('units_dailycashs.date >',$saldo->cut_off)
					->where('units_dailycashs.date <',$date)
					->get()->row();
		
		$cashout = $this->units->db->select('sum(amount) as amount')
					->from('units_dailycashs')
					->where('units_dailycashs.type','CASH_OUT')
					->where('units_dailycashs.id_unit', $idUnit)
					->where('units_dailycashs.date >',$saldo->cut_off)
					->where('units_dailycashs.date <',$date)
					->get()->row();

		return (object)array(
			'cashin' => (int)$cashin->amount,
			'cashout' => (int)$cashout->amount,
			'saldo' => (int)($saldo->amount+$cashin->amount) - $cashout->amount
		);
	}

	public function getCoc($gets, $percentageAnnualy = 11, $month = 0, $year = 0)
	{	
		if($month === 0){
			$month = date('m');
		}

		if($year === 0){
			$year = date('Y');
		}

		$daysInMonth = days_in_month($month, $year);

		$dateEnd = implode('-', array(
			$year, $month, $daysInMonth
		));

		if($gets){
			if(key_exists('area', $gets)){
				if( $gets['area']){
					$this->db->where('u.id_area', $gets['area']);
				}
			}
			if(key_exists('unit', $gets)){
				if($gets['unit']){
					$this->db->where('u.id', $gets['unit']);
				}
			}
		}

		$this->db
			->select("u.name, a.area,  ud.date, ud.amount,  CASE WHEN (DATEDIFF('$dateEnd',ud.date)+1) >= '$daysInMonth' THEN $daysInMonth ELSE (DATEDIFF('$dateEnd',ud.date)+1) END as tenor,
			 ROUND(ud.amount*$percentageAnnualy/100/365) as coc_daily,
			 ROUND( (ud.amount*$percentageAnnualy/100/365) * CASE WHEN (DATEDIFF('$dateEnd',ud.date)+1) >= '$daysInMonth' THEN $daysInMonth ELSE (DATEDIFF('$dateEnd',ud.date)+1) END) as coc_payment,			 
			 ")
			->from($this->table.' ud')
			->join('units u','u.id = ud.id_unit')
			->join('areas a','a.id = u.id_area')
			->where('MONTH(ud.date) <=', $month)
			->where('YEAR(ud.date)', $year)
			->where('no_perk','1110000')
			->order_by('a.id','ASC')
			->order_by('coc_payment','DESC');
		return $this->db->get()->result();
	}
}
