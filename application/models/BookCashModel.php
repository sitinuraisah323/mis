<?php
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

}
