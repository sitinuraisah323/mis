<?php
require_once 'Master.php';
class CustomersModel extends Master
{
	public $table = 'customers';

	public $primary_key = 'id';

	public function current($permit, $area)
	{
		$getCustomer = $this->db
			->select('distinct(customers.id), customers.name, no_cif')
			->from('customers')
			->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
			->join('units','units.id = units_regularpawns.id_unit')
			->where('units.id_area', $area)
			->where('permit', $permit)
			->where('status_transaction','N')
			->get()
			->result();

		
		$countCustomer = count($getCustomer);

		$bigger = 0;
		$smaller = 0;

		if($getCustomer){
			foreach($getCustomer as $customer){
				$amount = $this->db
						->select('sum(units_regularpawns.amount) as amount')
						->from('customers')
						->join('units_regularpawns','units_regularpawns.id_customer = customers.id')
						->join('units','units.id = units_regularpawns.id_unit')
						->where('units.id_area', $area)
						->where('permit', $permit)
						->where('status_transaction','N')
						->where('units_regularpawns.id_customer', $customer->id)
						->get()
						->row();
				if($amount->amount >= 100000000){
					$bigger++;
				}else{
					$smaller++;
				}
				
			}
		}
		

		return array(
			'customer_per_person'	=> $countCustomer,
			'transaction_bigger'	=> $bigger,
			'transaction_smaller'	=> $smaller,
		);
	}

	// public function usia()
	// {
		
	// 	$getUsia = $this->db
	// 		->select('distinct(customers.id), TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age')
	// 		->from('customers')
	// 		->join('units','units.id = customers.id_unit')->get()
	// 		->result();
	// 		return $getUsia;


	// }
	// public function usiadari($usiasampai)
	// {
	// 	$user_unit=$this->session->userdata( 'user' )->level == 'unit' ->id_unit;
	// 	$getUsiasampai = $this->db
	// 		->select('distinct(customers.id), *')
	// 		->from('customers')
	// 		->join('units','units.id = customers.id_unit')
	// 		->where('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) ', $usiasampai)
	// 		->where('id_unit', $user_unit)
	// 		return $this->db->get('customers')->result();

	// }
 }
