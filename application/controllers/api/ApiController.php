<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller {

	public $table;

	public function __construct()
	{
		parent::__construct();
	}

	public function sendMessage($data, $message, $status)
	{
		echo json_encode(array(
			'data'	=> $data,
			'message'	=> $message,
			'status'	=> $status
		));
	}

}
