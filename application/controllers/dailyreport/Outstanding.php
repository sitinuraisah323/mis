<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Outstanding extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Outstanding';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
        parent::__construct();
        $this->load->library('pdf');
		$this->load->model('UsersModel','model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';
		$pdf->AddPage('L');
		$users = $this->model->all();
		$view = $this->load->view('dailyreport/outstanding/index.php',[
			'users'	=> $users
		],true);
		$pdf->writeHTML($view);
		$pdf->Output('GHAnet_'.date('d_m_Y').'.pdf', 'I');
    }

}
