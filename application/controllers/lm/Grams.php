<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Grams extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Dashboards';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmGramsModel','grams');
		$this->load->model('LmGramsPricesModel','prices');
		$this->load->model('EmployeesModel','employees');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$grams = $this->grams->all();
		if($grams){
			foreach ($grams as $gram){
				$this->prices->db->order_by('lm_grams_prices.id','desc');
				$prices = $this->prices->find(array(
					'id_lm_gram'	=> $gram->id
				));
				if($prices){
					$gram->price_perpcs = $prices->price_perpcs;
					$gram->price_buyback_perpcs = $prices->price_buyback_perpcs;
				}
			}
		}
		$this->load->view("lm/gram/index",array(
			'grams'	=> $grams
		));
	}

	public function purchase()
	{
		$this->employees->db
			->select('units.name as unit')
			->order_by('employees.fullname','asc')
			->join('units','units.id = employees.id_unit');
		$employees = $this->employees->all();
		$this->load->view("lm/gram/purchase",array(
			'employees'	=> $employees
		));
	}

}
