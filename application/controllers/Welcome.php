<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Welcome extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'WELCOME';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsModel','units');
		$this->load->model('RegularPawnsModel','regular');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('index', array(
			'units'	=> $this->dashboardOutstanding()
		));
	}

	public function dashboardOutstanding()
	{
		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
		foreach ($units as $unit){
			$unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, date('Y-m-d'));
			$unit->credit_today = $this->regular->getCreditToday($unit->id, date('Y-m-d'));
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, date('Y-m-d'));
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
			$unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id);
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, date('Y-m-d'));
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, date('Y-m-d'));
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id, date('Y-m-d'));
			$unit->total_dpd = (object) array(
				'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa - $unit->dpd_repayment_today->noa,
				'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost - $unit->dpd_repayment_today->ost,
			);
			$unit->persentage = $unit->total_dpd->ost > 0 ? $unit->total_dpd->ost / $unit->total_dpd->noa : 0;
		}
		return $units;
	}


}
