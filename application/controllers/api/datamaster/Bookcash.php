<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Bookcash extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('BookCashModel', 'model');
		$this->load->model('BookCashModelModel', 'money');
		$this->load->model('FractionOfMoneyModel', 'fraction');
		
	}

	public function index()
	{
		$this->model->db
			->select('units.name as unit_name')
			->join('units','units.id = units_cash_book.id_unit');
		if($this->session->userdata('user')->level != 'administrator'){
			$this->model->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->model->db
					->select('units.name as unit_name')
					->join('units','units.id = units_cash_book.id_unit')
					->or_like('units.name', $value);
			}
		}
		$this->model->db->order_by('id','DESC');
		$data = $this->model->all();
		echo json_encode(array(
			'data'	=> 	$data,
			'message'	=> 'Successfully Get Data Menu'
		));
	}

	public function insert()
	{
		if($post = $this->input->post()){
			$this->load->library('form_validation');

			$this->form_validation->set_rules('kasir', 'Kasir', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('saldoawal', 'saldo awal', 'required');
			$this->form_validation->set_rules('saldoakhir', 'aaldo akhir', 'required');
			$this->form_validation->set_rules('penerimaan', 'penerimaan', 'required');
			$this->form_validation->set_rules('pengeluaran', 'pengeluaran', 'required');
			$this->form_validation->set_rules('totmutasi', 'total mutasi', 'required');
			$this->form_validation->set_rules('mutasi', 'mutasi', 'required');
			$this->form_validation->set_rules('os_unit', 'OS unit', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'status'	=> false,
					'message'	=> validation_errors()
				));
			}
			else
			{
				$date =  date('Y-m-d',strtotime($post['date']));
				$data = array(
					'id_unit'				=> $post['id_unit'],
					'date'					=> $date,
					'kasir'					=> $post['kasir'],
					'amount_balance_first'	=> $this->convertNumber($post['saldoawal']),
					'amount_in'				=> $this->convertNumber($post['penerimaan']),
					'amount_out'			=> $this->convertNumber($post['pengeluaran']),
					'amount_balance_final'	=> $this->convertNumber($post['saldoakhir']),
					'amount_mutation'		=> $post['mutasi'],
					'note'					=> $post['note'],
					'total'					=> $this->convertNumber($post['total']),
					'amount_gap'			=> $this->convertNumber($post['selisih']),
					'os_unit'				=> $this->convertNumber($post['os_unit']),
					'timestamp'		=> date('Y-m-d H:i:s'),
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
					'os'	=> $post['os']
				);
				
				$check = $this->db->get_where('units_cash_book',array('id_unit' => $post['id_unit'],'date'=> $date));
				if($check->num_rows() > 0){
					echo json_encode(array(
						'data'	=> 	false,
						'status'	=> false,
						'message'	=> 'Anda sudah input BAP Kas hari ini, silahkan update jika ada perubahan')
					);
				}else{
					if($this->model->insert($data)){
						$idUnitCashBook = $this->model->last()->id;

						$kertas_pecahan = $post['k_pecahan'];
						for ($i=0; $i < count($kertas_pecahan); $i++) {
							$kertas['id_unit_cash_book'] 	= $idUnitCashBook;
							$kertas['id_fraction_of_money'] = $post['k_fraction'][$i];
							$kertas['amount'] 				= $kertas_pecahan[$i];
							$kertas['summary'] 				= $post['k_jumlah'][$i];
							$this->money->insert($kertas);
						}

						$logam_pecahan = $post['l_pecahan'];
						for ($j=0; $j < count($logam_pecahan); $j++) {
							$logam['id_unit_cash_book'] 	= $idUnitCashBook;
							$logam['id_fraction_of_money'] 	= $post['l_fraction'][$j];
							$logam['amount'] 				= $logam_pecahan[$j];
							$logam['summary'] 				= $post['l_jumlah'][$j];
							$this->money->insert($logam);
						}

						echo json_encode(array(
									'data'	=> 	true,
									'status'	=> true,
									'message'	=> 'Successfull Insert Data Saldo'
						));

					}else{
						echo json_encode(array(
								'data'	=> 	false,
								'status'	=> false,
								'message'	=> 'Failed Insert Data Menu')
							);
					}
				}			
			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function update()
	{
		if($post = $this->input->post()){
			$this->load->library('form_validation');

			$this->form_validation->set_rules('e_kasir', 'kasir', 'required');
			$this->form_validation->set_rules('e_date', 'date', 'required');
			$this->form_validation->set_rules('e_saldoawal', 'saldo awal', 'required');
			$this->form_validation->set_rules('e_saldoakhir', 'saldo akhir', 'required');
			$this->form_validation->set_rules('e_penerimaan', 'penerimaan', 'required');
			$this->form_validation->set_rules('e_pengeluaran', 'pengeluaran', 'required');
			$this->form_validation->set_rules('e_totmutasi', 'total mutasi', 'required');
			$this->form_validation->set_rules('e_os_unit', 'os unit', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'status'	=> false,
					'message'	=> validation_errors()
				));
			}
			else
			{
				$id = $post['id_edit'];
				$data = array(
					//'id_unit'				=> $post['id_unit'],
					'date'					=> $post['e_date'],
					'kasir'					=> $post['e_kasir'],
					'amount_balance_first'	=> $this->convertNumber($post['e_saldoawal']),
					'amount_in'				=> $this->convertNumber($post['e_penerimaan']),
					'amount_out'			=> $this->convertNumber($post['e_pengeluaran']),
					'amount_balance_final'	=> $this->convertNumber($post['e_saldoakhir']),
					'amount_mutation'		=> $post['e_mutasi'],
					'note'					=> $post['e_note'],
					'total'					=> $this->convertNumber($post['e_total']),
					'amount_gap'			=> $this->convertNumber($post['e_selisih']),
					'os_unit'				=> $this->convertNumber($post['e_os_unit']),
					'timestamp'		=> date('Y-m-d H:i:s'),
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
					'os'	=> $post['os']
				);
				
				if($this->model->update($data,$id)){
					$idUnitCashBook = $id;			
					$kertas_pecahan = $post['e_k_pecahan'];
					for ($i=0; $i < count($kertas_pecahan); $i++) {
						$id_update 						= $post['e_k_money'][$i];
						$kertas['amount'] 				= $kertas_pecahan[$i];
						$kertas['summary'] 				= $post['e_k_jumlah'][$i];
						$this->money->update($kertas,$id_update);
					}

					$logam_pecahan = $post['e_l_pecahan'];
					for ($j=0; $j < count($logam_pecahan); $j++) {
						//$logam['id_unit_cash_book'] 	= $idUnitCashBook;
						//$logam['id_fraction_of_money'] 	= $post['l_fraction'][$j];
						$id_update 					= $post['e_l_money'][$j];
						$logam['amount'] 				= $logam_pecahan[$j];
						$logam['summary'] 				= $post['e_l_jumlah'][$j];
						$this->money->update($logam,$id_update);
					}

					echo json_encode(array(
								'data'	=> 	true,
								'status'	=> true,
								'message'	=> 'Successfull Insert Data Saldo'
					));

				}else{
					echo json_encode(array(
							'data'	=> 	false,
							'status'	=> false,
							'message'	=> 'Failed Insert Data Menu')
						);
				}			
			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function update_x()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_unit', 'Unit', 'required');
			$this->form_validation->set_rules('id', 'Id', 'required');



			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'status'	=> false,
					'message'	=> 'Failed Insert Data Level'
				));
			}
			else
			{
				$id = $post['id'];
				$data = array(
					'total'	=> $post['total'],
					'id_unit'	=> $post['id_unit'],
					'timestamp'	=> date('Y-m-d H:i:s'),
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->update($data, $id)){
					$idUnitCashBook = $id;
					$this->money->delete(array(
						'id_unit_cash_book'	=> $idUnitCashBook
					));
					foreach ($post['fraction'] as $fraction){
						$this->money->insert(array(
							'id_unit_cash_book'	=> $idUnitCashBook,
							'id_fraction_of_money'	=> $fraction['id_fraction_of_money'],
							'amount'	=> $fraction['amount'],
							'summary'	=> $fraction['summary'],
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						));
					}
					echo json_encode(array(
						'data'	=> 	true,
						'status'	=> true,
						'message'	=> 'Successfull Update Data Level'
					));
				}else{
					echo json_encode(array(
							'data'	=> 	false,
							'status'	=> false,
							'message'	=> 'Failed Update Data Level')
					);
				}

			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function show($id)
	{
		$this->model->db
			->select('name as unit_name')
			->join('units','units.id = units_cash_book.id_unit');
		if($data = $this->model->find(array(
			'units_cash_book.id'	=> $id
		))){
			$this->money->db
				->select('fraction_of_money.read')
				->join('fraction_of_money','fraction_of_money.id = units_cash_book_money.id_fraction_of_money');
			$data->detail = $this->money->findWhere(array(
				'id_unit_cash_book'	=> $data->id
			));
			echo json_encode(array(
				'data'	=> 	$data,
				'status'	=> true,
				'message'	=> 'Successfully Delete Data Level'
			));
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> 	false,
				'message'	=> $id. ' Not Found'
			));
		}
	}

	public function get_type_money_kertas()
	{
		$this->fraction->db
					->where('type', 'KERTAS')
					->order_by('amount', 'DESC');		
		$data = $this->fraction->all();
		echo json_encode(array(
			'data'	  => $data,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function get_type_money_logam()
	{
		$this->fraction->db
		->where('type', 'LOGAM')		
		->order_by('amount', 'DESC');		
		$data = $this->fraction->all();
		echo json_encode(array(
			'data'	  => $data,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function delete($id)
	{
		if($this->model->delete($id)){
			//$this->model->buildHirarki();
			echo json_encode(array(
				'data'	=> 	true,
				'status'	=> true,
				'message'	=> 'Successfully Delete Data Level'
			));
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> false,
				'message'	=> 'Request Error Should Method Post'
			));
		}
	}

	public function report()
	{
		if($get = $this->input->get()){			
			$this->model->db
				->select('units.name as unit_name')
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($this->input->get('id_unit')){
				$this->model->db->where('id_unit', $get['id_unit']);
			}
			if($this->input->get('area')){
				$this->model->db->where('id_area', $get['area']);
			}
			$this->model->db->order_by('id', 'desc');
		}
		$this->model->db->join('units','units.id = units_cash_book.id_unit');
		$data = $this->model->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function getBookCash()
	{
		//if($get = $this->input->get()){	
			$get = $this->input->get();		
			$data = $this->model->db
				->from('units_cash_book')
				->select('units.name,units_cash_book.*')
				->join('units','units_cash_book.id_unit=units.id')
				->where('units_cash_book.id', $get['id']);
		//}
		//$data = $this->model->all();
		//$query = $data->get()->row();
		echo json_encode(array(
			'data'	=> $data->get()->row(),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function getDetailBookCash()
	{
		if($get = $this->input->get()){			
			$this->money->db
				->select('fraction_of_money.type')
				->join('fraction_of_money','units_cash_book_money.id_fraction_of_money=fraction_of_money.id')
				->where('id_unit_cash_book', $get['id'])
				->order_by('fraction_of_money.amount', 'desc');
		}
		$data = $this->money->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function convertNumber($angka){
		$clean = preg_replace('/\D/','',$angka);
		return $clean;
	}

}
