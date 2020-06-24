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
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		echo "index dahsboard";
    }

    public function pusat()
	{
        echo "pusat";
        //$this->load->view("dashboards/pusat/index");
    }

    public function area()
	{
		
    }

    public function units()
	{
		
    }
    

}
