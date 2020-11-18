<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Unitsdailycash extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('UnitsSaldo', 'saldo');
	}

	public function index()
	{

	}

	public function get_unitsdailycash()
	{
		echo json_encode(array(
			'data'	=> 	$this->unitsdailycash->get_unitsdailycash(),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
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
				// foreach ($unitsdailycash as $key => $udc){
				// 	if($key > 1){
				// 		$data = array(
				// 			'no_cif'	=> zero_fill($udc['A'], 4),
				// 			'name'	=> $udc['B'],
				// 			'birth_date'	=> date('Y-m-d', strtotime($customer['E'])),
				// 			'mobile'	=>  "0".$customer['C'],
				// 			'birth_place'	=>  $customer['F'],
				// 			'address'	=> $customer['G'],
				// 			'nik'	=> $customer['I'],
				// 			'city'	=> $customer['F'],
				// 			'sibling_name'	=> $customer['N'],
				// 			'sibling_address_1'	=> $customer['O'],
				// 			'sibling_address_2'	=> $customer['P'],
				// 			'sibling_relation'	=> $customer['AB'],
				// 			'province'	=> $customer['T'],
				// 			'job'	=> $customer['U'],
				// 			'mother_name'	=> $customer['V'],
				// 			'citizenship'	=> $customer['W'],
				// 			'sibling_birth_date'	=> date('Y-m-d', strtotime($customer['K'])),
				// 			'sibling_birth_place'	=> $customer['J'],
				// 			'gender'	=> $customer['Z'] == 'L' ? 'MALE' : 'FEMALE',
				// 			'user_create'	=> 1,
				// 			'user_update'	=> 1
				// 		);
				// 		if($findCustomer = $this->customers->find(array(
				// 			'nik'	=> $customer['I']
				// 		))){
				// 			if($this->customers->update($data, array(
				// 				'id'	=>  $findCustomer->id
				// 			)));
				// 		}else{
				// 			$this->customers->insert($data);
				// 		}
				// 	}
				// }
				echo json_encode(array(
					'data'	    => $unit,
					'status'	=> 	true,
					'message'	=> 'Successfully Updated Upload'
				));
			}
			// if(is_file($path)){
			// 	unlink($path);
			// }
		}
	}
	
	public function delete()
	{
		if($post = $this->input->get()){

            $data['id'] = $this->input->get('id');	
            $db = false;
            $db = $this->unitsdailycash->delete($data);
            if($db=true){
                echo json_encode(array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Delete Data Area'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Delete Data Area'
                ));
            }
        }	
	}
	
	public function report()
	{
		if($get = $this->input->get()){
			if($get['dateStart']){
				$this->unitsdailycash->db->where('date <', $get['dateStart']);
			}
			if($get['id_unit']!='all' && $get['id_unit'] != 0){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
			if($this->input->get('area')){
				$this->unitsdailycash->db->where('id_area', $get['area']);
			}
		}
		$this->unitsdailycash->db
			->select('
			 (sum(CASE WHEN type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN type = "CASH_OUT" THEN `amount` ELSE 0 END)) as amount
			 			')
			->from('units_dailycashs')
			->join('units','units.id = units_dailycashs.id_unit');
		$saldo = (int) $this->unitsdailycash->db->get()->row()->amount;
		$data = (object) array(
			'id'	=> 0,
			'id_unit' => $this->input->get('id_unit') ? $this->input->get('id_unit') : 0,
			'no_perk'	=> 0,
			'date'	=> '',
			'description'	=> 'saldo awal',
			'cash_code'	=>  'KT',
			'type'	=> $saldo > 0 ? 'CASH_IN' : 'CASH_OUT',
			'amount'	=> abs($saldo)
		);

		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($get['id_unit']!='all' && $get['id_unit'] != 0){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
			if($this->input->get('area')){
				$this->unitsdailycash->db->where('id_area', $get['area']);
			}
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$getCash = $this->unitsdailycash->all();
		array_unshift( $getCash, $data);
		echo json_encode(array(
			'data'	  => $getCash,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function bukubank()
	{
		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('SUBSTRING(no_perk,1,5) =','11100')
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($this->input->get('id_unit')){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	  => $data,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function modal_kerja_pusat()
	{
		$ignore = array('1110000');
		if($get = $this->input->get()){
			$category = $get['category'];
			if($this->input->get('dateEnd')){
				$this->unitsdailycash->db->where('date <=', $get['dateEnd']);
			}

			if($this->input->get('dateStart')){
				$this->unitsdailycash->db->where('date >=', $get['dateStart']);
			}

			if($this->input->get('id_unit')){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
				if($category=='0'){
					$this->unitsdailycash->db->where('no_perk', '1110000');
				}
				if($category=='1'){
					$this->unitsdailycash->db
					->where('SUBSTRING(no_perk,1,5) =','11100')
					->where('type =', 'CASH_IN')
					->where_not_in('no_perk', $ignore);
				}
		}
		$this->unitsdailycash->db
			->select('units.name as unit')
			->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function modal_kerja_mutasi_unit()
	{
		$ignore = array('1110000');
		$this->unitsdailycash->all();
		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('SUBSTRING(no_perk,1,5) =','11100')
				->where('type =', 'CASH_IN')
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit'])
				->where_not_in('no_perk', $ignore);
		}
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully get data modal kerja mutasi antar unit'
		));
	}

	public function pendapatan()
	{
		if($get = $this->input->get()){
			$category =null;
			if($get['category']=='all'){
				$data = $this->m_casing->get_list_pendapatan();
				$category=array();
				foreach ($data as $value) {
					array_push($category, $value->no_perk);
				}
			}else{
				$category=array($get['category']);
			}
			$this->unitsdailycash->db
				->where('type =', 'CASH_IN')
				->where_in('no_perk', $category)
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($this->input->get('id_unit')){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
			if($this->input->get('area')){
				$this->unitsdailycash->db->where('id_area', $get['area']);
			}
		}
		$this->unitsdailycash->db
			->select('units.name as unit')
			->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function summarycashin()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('unit')){
			$this->units->db->where('units.id', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($perk = $this->input->get('perk')){
			$perk = $perk;
		}		
		if($this->input->get('dateStart')){
			$dateStart = $this->input->get('dateStart');
		}else{
			$dateStart = date('Y-m-d');
		}

		if($this->input->get('dateEnd')){
			$dateEnd = $this->input->get('dateEnd');
		}else{
			$dateEnd = date('Y-m-d');
		}

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('areas.id','asc')
			->get('units')->result();
		foreach ($units as $unit){
			 $unit->summary = $this->unitsdailycash->getSummaryCashin($dateStart,$dateEnd,$perk,$unit->id);			
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function pengeluaran()
	{
		if($get = $this->input->get()){
			$category =null;
			if($get['category']=='all'){
				$data = $this->m_casing->get_list_pengeluaran();
				$category=array();
				foreach ($data as $value) {
					array_push($category, $value->no_perk);
				}
			}else{
				$category=array($get['category']);
			}
			$this->unitsdailycash->db
				->where('type =', 'CASH_OUT')
				->where_in('no_perk', $category)
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($this->input->get('id_unit')){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
			if($this->input->get('area')){
				$this->unitsdailycash->db->where('id_area', $get['area']);
			}
		}
		$this->unitsdailycash->db
			->select('units.name as unit')
			->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function saldoawalproses()
	{
		require_once APPPATH.'libraries/PHPExcel.php';
		$path = 'storage/files/saldo/saldo.xlsx';
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
		$transactions = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		if($transactions){
			$batchInsert = array();
			$batchUpdate = array();
			foreach ($transactions as $key => $transaction){
				if($key > 1){
					if($this->units->find($transaction['A'])){
						$partAmount =  explode(',',$transaction['E']);
						$amount = implode('',$partAmount);
						$data = array(
							'id_unit'	=> $transaction['A'],
							'amount'	=> $amount,
							'cut_off'	=> $transaction['F']
						);
						$batchInsert[] = $data;
					}

				}
			}
			if(count($batchInsert)){
				$this->unitsdailycash->db->insert_batch('units_saldo', $batchInsert);
			}
			if(count($batchUpdate)){
				$this->unitsdailycash->db->update_batch('customers', $batchUpdate,'id');
			}
		}
//		if(is_file($path)){
//			unlink($path);
//		}
	}

	public function reportsaldoawal()
	{
		$area = $this->input->get('area');
		$idUnit = $this->input->get('id_unit');
		$dateStart = $this->input->get('dateStart');
		$dateEnd = $this->input->get('dateEnd');
		if($area > 0){
			$this->saldo->db->where('id_area', $area);
		}
		if($idUnit > 0){
			$this->saldo->db->where('id_unit', $idUnit);
		}
		if($dateStart){
			$this->saldo->db->where('cut_off <=', $dateStart);
		}

		$this->saldo->db
			->select('sum(amount) as amount, cut_off')
			->select('units.name')
			->from('units_saldo')
			->group_by('cut_off')
			->join('units','units.id = units_saldo.id_unit');
		$getSaldo = $this->saldo->db->get()->row();
		if($getSaldo){
			$totalsaldoawal = (int) $getSaldo->amount;
			$date = $getSaldo->cut_off;
		}else{
			$totalsaldoawal = 0;
			$date = '';
		}


		if($area > 0){
			$this->saldo->db->where('id_area', $area);
		}
		if($idUnit > 0){
			$this->saldo->db->where('id_unit', $idUnit);
		}
		if($date){
			$this->saldo->db->where('date >', $date);
		}

		if($dateStart){
			$this->saldo->db->where('date <', $dateStart);
		}

		$this->unitsdailycash->db
			->select('
			 (sum(CASE WHEN type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN type = "CASH_OUT" THEN `amount` ELSE 0 END)) as amount
			 			')
			->from('units_dailycashs')
			->join('units','units.id = units_dailycashs.id_unit');
		$saldo = (int) $this->unitsdailycash->db->get()->row()->amount;
		$total = $saldo + $totalsaldoawal;


		$data = (object) array(
			'id'	=> 0,
			'name'	=> $getSaldo->name,
			'id_unit' => $this->input->get('id_unit') ? $this->input->get('id_unit') : 0,
			'no_perk'	=> 0,
			'date'	=> '',
			'description'	=> 'saldo awal',
			'cash_code'	=>  'KT',
			'type'	=> $total > 0 ? 'CASH_IN' : 'CASH_OUT',
			'amount'	=> $total
		);

		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($get['id_unit']!='all' && $get['id_unit'] != 0){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
			if($get['permit']!='All'){
				$this->unitsdailycash->db->where('permit', $get['permit']);
			}
			if($this->input->get('area')){
				$this->unitsdailycash->db->where('id_area', $get['area']);
			}
		}
		$this->unitsdailycash->db
			->select('units.name')
			->join('units','units.id = units_dailycashs.id_unit');
		$getCash = $this->unitsdailycash->all();
		array_unshift( $getCash, $data);
		echo json_encode(array(
			'data'	=> 	$getCash,
			'status'=>true,
			'message'	=> 'Successfull Delete Data Area'
		));
	}

	public function lmtransaction()
	{	
		if($area = $this->input->get('area')){
            $this->units->db->where('id_area', $area);
        }else if($this->session->userdata('user')->level === 'area'){
            $this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		
		if($code = $this->input->get('unit')){
			if($code!='0'){
			$this->units->db->where('units.id', $code);
			}
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}	
		$dateStart = $this->input->get('dateStart');
		$dateEnd = $this->input->get('dateEnd');

        if($this->session->userdata('user')->level === 'unit'){
            $this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
        }else if($unit = $this->input->get('id_unit')){
            $this->units->db->where('units.id', $unit);
		}
		
		$this->units->db->select('units.id, name, areas.area')
						 ->join('areas','areas.id = units.id_area')
						 ->select('no_perk,date,description,amount,type,permit')
						 ->join('units_dailycashs','units.id = units_dailycashs.id_unit')
						 ->where('date >=',$dateStart)
						 ->where('date <=',$dateEnd)
						 ->where('no_perk ','1110102');
        $units = $this->units->db->get('units')->result();			

		return $this->sendMessage($units,'Successfully get report realisasi');
	}

	public function coc()
	{
		return $this->sendMessage($this->unitsdailycash->getCoc($this->input->get(), $this->input->get('percentage'), $this->input->get('month'), $this->input->get('year'), $this->input->get('period_month'), $this->input->get('period_year')), 'Successfully get Coc');
	}

	public function pengeluran_perk()
	{
		
		$daily = $this->unitsdailycash->pengeluaran_perk();

		return $this->sendMessage($daily, 'success', 200);
	}

}
