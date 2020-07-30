<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Dashboards extends Authenticated
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
		$this->load->model('AreasModel','areas');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view("dashboard/index",array(
			'areas'	=> $this->areas->all()
		));
	}

	public function new()
	{
		$this->load->view("dashboard/_index",array(
			'areas'	=> $this->areas->all()
		));
	}

	public function unit()
	{
		$this->load->view("dashboard/unit/index");
	}

	public function executivesummary()
	{
		$this->load->view("dashboard/summary/index",array(
			'areas'	=> $this->areas->all()
		));
	}

	public function outstanding()
	{
		$this->load->view("dashboard/outstanding/index.php",array(
			'areas'	=> $this->areas->all()
		));
    }
	
	public function dpd()
	{
		$this->load->view("dashboard/dpd/index.php",array(
			'areas'	=> $this->areas->all()
		));
    }

    public function pusat()
	{
        $this->load->view("dashboards/pusat/index");
	}
	
	public function performaunit()
	{
        $this->load->view("dashboards/pusat/performaunit");
	}
	
	
	public function disburse()
	{
        $this->load->view("dashboards/pusat/disburse");
	}

	public function targetbooking()
	{
        $this->load->view("dashboards/pusat/targetbooking");
	}
	
	public function targetoutstanding()
	{
        $this->load->view("dashboards/pusat/targetoutstanding");
	}
	
	public function pencairan()
	{
        $this->load->view("dashboard/pencairan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}
	
	public function pelunasan()
	{
        $this->load->view("dashboard/pelunasan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pendapatan()
	{
        $this->load->view("dashboard/pendapatan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pengeluaran()
	{
        $this->load->view("dashboard/pengeluaran/index",array(
        	'areas'	=> $this->areas->all()
		));
	}
	
	public function saldokas()
	{
        $this->load->view("dashboards/pusat/saldokas");
	}
	
	public function saldobank()
	{
        $this->load->view("dashboards/pusat/saldobank");
    }

    public function area()
	{
		$this->load->view("dashboards/area/index");
    }

    public function units()
	{
		$this->load->view("dashboards/units/index");
    }
    

}
