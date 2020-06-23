<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Unitsdailycash extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Units Daily Cash';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['units'] = $this->units->all();
		$this->load->view('transaction/unitsdailycash/index',$data);
	}

	public function upload()
	{
		$config['upload_path']          = 'storage/unitsdailycash/data/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/unitsdailycash/data/')){
			mkdir('storage/unitsdailycash/data/',0777,true);
		}

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array(
				'data'	=> 	$error,
				'message'	=> 'Request Error Should Method Post'
			));
		}
		else
		{
            $unit       = $this->input->post('unit');
            $date       = date('Y-m-d',strtotime($this->input->post('datetrans'))); 
            $cashcode   = $this->input->post('kodetrans');

			$data = $this->upload->data();
			$path = $config['upload_path'].$data['file_name'];

			include APPPATH.'libraries/PHPExcel.php';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
			$unitsdailycash = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			if($unitsdailycash){
				foreach ($unitsdailycash as $key => $udc){
					if($key > 1){
						$datetrans 	= date('Y-m-d', strtotime($udc['E']));
						$kdkas		= $udc['F'];
						if($datetrans>=$date && $datetrans<=$date){
							if($kdkas==$cashcode){
								$data = array(
									'id_unit'		=> $unit,
									'cash_code'		=> $udc['F'],
									'date'			=> $datetrans,
									'amount'		=> $udc['B'],
									'description'	=> $udc['C'],							
									'type'			=> null,							
									'status'		=> "DRAFT"							
								);
								//echo "<pre/>";
								//print_r($data);
								if($findudc = $this->unitsdailycash->find(array(
									'id_unit'		=> $unit,
									'cash_code'		=> $kdkas,
									'date'			=> $datetrans,
									'description' 	=> $udc['C']
								))){
									if($this->unitsdailycash->update($data, array(
										'id'	=>  $findudc->id
									)));
								}else{
									$this->unitsdailycash->insert($data);
								}
							}							
						}						
					    
					}
				}
				// echo json_encode(array(
				// 	'data'	    => $unit,
				// 	'status'	=> 	true,
				// 	'message'	=> 'Successfully Updated Upload'
				// ));
			}
			if(is_file($path)){
				unlink($path);
			}
		}
		redirect('transaction/unitsdailycash');
	}

}
