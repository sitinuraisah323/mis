<?php
require_once 'Master.php';
class LmStocksModel extends Master
{
	/**
	 * @var string
	 */

	public $table = 'lm_stocks';

	/**
	 * @var string
	 */

	public $primary_key = 'id';

	public $hirarki = false;
}
