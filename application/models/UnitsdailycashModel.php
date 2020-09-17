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
}
