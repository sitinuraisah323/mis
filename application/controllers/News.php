<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class News extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'News';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('NewsContentsAttachments','attachments');
		$this->load->model('NewsContents','model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view("news/index");
	}
	
	public function detail($id)
	{
		$data = $this->model->find($id);
		$data->attachments = $this->attachments->findWhere(array(
			'id_news_content'	=> $data->id
		));
		var_dump($data);
		exit;

		return $this->load->view("news/detail",[
			'data'	=> $data
		]);
	}

}
