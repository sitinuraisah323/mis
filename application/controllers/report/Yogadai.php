<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Yogadai extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'BAPKas';

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
        //$data['areas'] = $this->areas->all();
		//$this->load->view('report/yogadai/outstanding/index');
    }
    
    public function outstanding()
	{
		$this->load->view('report/yogadai/outstanding/index');
	}

}
