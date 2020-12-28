<?php
require_once 'Master.php';
class CustomersModel extends Master
{
	public $table = 'customers';

	public $primary_key = 'id';

	public function current($permit, $area)
	{
		
		$customerPerPersion = $this->db
			->select('count(distinct(customers.id)) as per_person')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('permit', $permit)
			->get()
			->row();
		$transactionBigger = $this->db
			->select('count(*) as bigger')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('amount >=', 100000000)
			->where('permit', $permit)
			->get()
			->row();
		$transactionSmaller = $this->db
			->select('count(*) as small')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('amount <', 100000000)
			->where('permit', $permit)
			->get()
			->row();

		$customerPerPersionDetail = $this->db
			->select('distinct(customers.id)')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('permit', $permit)
			->get()
			->result();
		$transactionBiggerDetail = $this->db
			->select('*')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('amount >=', 100000000)
			->where('permit', $permit)
			->get()
			->result();
		$transactionSmallerDetail = $this->db
			->select('*')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('amount <', 100000000)
			->where('permit', $permit)
			->get()
			->result();

		return array(
			'customer_per_person'	=> $customerPerPersion->per_person,
			'transaction_bigger'	=> $transactionBigger->bigger,
			'transaction_smaller'	=> $transactionSmaller->small,
			'details'	=> array(
				'customer_per_person'	=> $customerPerPersionDetail,
				'transaction_bigger'	=> $transactionBiggerDetail,
				'transaction_smaller'	=> $transactionSmallerDetail,
			)
		);
	}
}
