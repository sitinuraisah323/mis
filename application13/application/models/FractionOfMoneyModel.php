<?php
require_once 'Master.php';
class FractionOfMoneyModel extends Master
{
	public $table = 'fraction_of_money';

	public $primary_key = 'id';

	public function all($limit = null)
	{
		$this->db->order_by($this->primary_key,'ASC');
		return parent::all($limit); // TODO: Change the autogenerated stub
	}

}
