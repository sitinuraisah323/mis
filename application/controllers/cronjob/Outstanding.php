<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
error_reporting(0);
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
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		$this->load->model('AreasModel', 'model');
		$this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('regularpawnshistoryModel', 'regularrepair');
		$this->load->model('MortagesModel', 'mortages');
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('CustomersrepairModel', 'customersrepair');		
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $currdate =date("Y-m-d");
        $nextdate = date('Y-m-d', strtotime('+1 days', strtotime($currdate)));
        $lastdate = date('Y-m-d', strtotime('-1 days', strtotime($currdate)));

      $date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
      }
      
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			//  $unit->noa = $this->regular->getOstYesterday_($unit->id, $nextdate)->noa;			
         //  $unit->up = $this->regular->getOstYesterday_($unit->id, $nextdate)->up;
          $unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, $date);
			 $unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			 $unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			 $totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			 $totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
			 $unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			 );

             $data['id_unit']   = $unit->id;
             $data['date']      = $currdate;
             $data['noa']       = $unit->total_outstanding->noa;
             $data['os']        = $unit->total_outstanding->up;
             $check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$currdate));
             if($check->num_rows() > 0){
                $this->db->update('units_outstanding', $data, array('id_unit' => $unit->id,'date'=>$currdate));
             }else{
                $this->db->insert('units_outstanding', $data);
             }
		}
        
	}

	public function yesterday()
	{
        $currdate = date("Y-m-d");
        $nextdate = date('Y-m-d', strtotime('+1 days', strtotime($currdate)));
        $lastdate = date('Y-m-d', strtotime('-1 days', strtotime($currdate)));

         $date = date('Y-m-d');
         $lasttrans = $this->regular->getLastDateTransaction()->date;
         if ($date > $lasttrans){
            $date = $lasttrans;
         }else{
            $date= $date;
         }
      
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			    //$unit->noa = $this->regular->getOstYesterday_($unit->id, $currdate)->noa;			
             //$unit->up = $this->regular->getOstYesterday_($unit->id, $currdate)->up;
             $unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, $date);
             $unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
             $unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
             $totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
             $totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
             $unit->total_outstanding = (object) array(
               'noa'	=> $totalNoa,
               'up'	=> $totalUp,
               'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
             );

             $data['id_unit']   = $unit->id;
             $data['date']      = $lastdate;
             $data['noa']       = $unit->total_outstanding->noa;
             $data['os']        = $unit->total_outstanding->up;
             $check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$lastdate));
             if($check->num_rows() > 0){
                $this->db->update('units_outstanding', $data, array('id_unit' => $unit->id,'date'=>$lastdate));
             }else{
                $this->db->insert('units_outstanding', $data);
             }
		}
        
   	}
   
   public function cicilan()
	{
		$idunit ='1';
		$units = $this->db->select('id,id_unit,id_customer,no_sbk,nic,date_sbk,deadline,amount_loan,periode,status_transaction')
						->from('units_mortages')
						->where('id_unit',$idunit)
						->get()->result();
		foreach ($units as  $unit) {
			$unit->cicilan = $this->mortages->getMortages($unit->id_unit,$unit->no_sbk);
		}		
		$this->sendMessage($units, 'Get Data Outstanding');
        
	}

	public function generate_old(){
		
		if($date = $this->input->get('date')){
			$date = $date;
		}else{
			$date = date('Y-m-d');
		}

		$totalUp = 0;
		$totalNoa = 0;
		$totalPelunasan = 0;
		$totalPencairan = 0;

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('units.id','desc')
			->get('units')->result();

		foreach ($units as $unit){
			$getOstYesterday = $this->model->db
								->where('date <', $date)
								->from('units_outstanding')
								->where('id_unit', $unit->id)
								->order_by('date','DESC')
								->get()->row();

			$getNoaReg = $this->regular->db->select('select count(id) as noa')
			             ->from('units_regularpawns')
						 ->where('units_regularpawns.status_transaction ','N') 
						 ->where('units_regularpawns.amount !=','0') 
						 ->get()->row();

			$creditToday = $this->regular->getCreditToday($unit->id, $date);
			$repaymentToday = $this->regular->getRepaymentToday($unit->id, $date);

			$totalOstToday = array(
				'noa'	=> $getOstYesterday->noa+$creditToday->noa-$repaymentToday->noa,
				'up'	=> $getOstYesterday->os+$creditToday->up-$repaymentToday->up
			);
			
			$totalUp += $getOstYesterday->os+$creditToday->up-$repaymentToday->up;
			$totalNoa += $getOstYesterday->noa+$creditToday->noa-$repaymentToday->noa;
			$totalPelunasan += $repaymentToday->up;
			$totalPencairan += $creditToday->up;

			$data = array(
				'date'		=> $date,
				'noa'		=> $totalOstToday['noa'],
				'os'		=> $totalOstToday['up'],
				'id_unit'	=> $unit->id
			);
			
			$check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$date));
			if($check->num_rows() > 0){
				$this->db->update('units_outstanding', $data, array('id_unit' => $unit->id,'date'=>$date));
			}else{
				$this->db->insert('units_outstanding', $data);
			}
		}

		echo json_encode(
			array(
				'total_noa'	=> 'total noa '.$totalNoa.'<br>',
				'total_up'	=> 'total up'. $totalUp.'<br>',
				'total_pelunasan'	=>  'total pelunsan'. $totalPelunasan.'<br>',
				'total_pencairan'	=> 'total pencairan'. $totalPencairan.'<br>'
			)
		);
	}

	public function repairtransaction(){
		$db = false;
		$mastercustomer = $this->customersrepair->all();
		foreach ($mastercustomer as $customer){
			$id['id'] 		= $customer->reff_customers;
			$data['nik'] 	= $customer->ktp_customers;
			$db = $this->customers->update($data,$id);
		}

		$mastertransactions = $this->regularrepair->all();
		foreach ($mastertransactions as $regular){
			$idreg['id'] 		= $regular->reff_id;
			$reg['id_customer'] = $regular->customers_id;
			$db = $this->regular->update($reg,$idreg);
		}

		if($db){ echo "Success repair data";}
	}

	public function generate(){

		if($date = $this->input->get('date')){
			$date = $date;
		}else{
			$date = date('Y-m-d');
		}

		//$date = '2020-10-27';
		$totalUp = 0;
		$totalUpUnit = 0;
		$totalNoa = 0;
		$totalNoaUnit = 0;
		$totalPelunasan = 0;
		$totalPencairan = 0;

		$totalUpMortages = 0;
		$totalNoaMortages = 0;
		$totalPelunasanMortages = 0;
		$totalPencairanMortages = 0;
		$totalOst = 0;

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('units.id','asc')
			->get('units')->result();

		foreach ($units as $unit){
			//get os yesterday
			$getOstYesterday = $this->model->db
								->where('date <', $date)
								->from('units_outstanding')
								->where('id_unit', $unit->id)
								->order_by('date','DESC')
								->get()->row();
			
			// $sumUP = $this->regular->db->select('SUM(amount) as up,count(id) as noa')->from('units_regularpawns')
			// 		 ->where('id_unit', $unit->id)
			// 		 ->where('status_transaction','N')
			// 		 ->where('amount !=','0')
			// 		 ->get()->row();

			// $sumUPMortages = $this->regular->db->select('count(id) as noa')->from('units_mortages')
			// 		 ->where('id_unit', $unit->id)
			// 		 ->where('status_transaction','N')
			// 		 ->get()->row();

			$creditToday 	= $this->regular->getCreditToday($unit->id, $date);
			$repaymentToday = $this->regular->getRepaymentToday($unit->id, $date);	
			//$getOS 			= $this->regular->getOutstanding($unit->id, $date);
			//get real OS
			$realos 		= $this->regular->getRealOS($unit->id,$date);

			$dpddate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
			

		

			$totalNoaUnit = $getOstYesterday->noa_os_regular + $creditToday->noa_regular - $repaymentToday->noa_regular;
			$totalUpUnit  = $getOstYesterday->os_regular + $creditToday->up_regular - $repaymentToday->up_regular;
			
			//regular
			$totalUp += $totalUpUnit;
			$totalNoa += $totalNoaUnit;
			$totalPelunasan +=  $repaymentToday->up_regular;
			$totalPencairan +=  $creditToday->up_regular;

			$totalNoaUnitMortages = $getOstYesterday->noa_os_mortage + $creditToday->noa_mortage - $repaymentToday->noa_mortage;
			$totalUpUnitMortages  = $getOstYesterday->os_mortage + $creditToday->up_mortage - $repaymentToday->up_mortage;

			//mortages			
			$totalPelunasanMortages +=  $repaymentToday->up_mortage;
			$totalPencairanMortages +=  $creditToday->up_mortage;
			$totalUpMortages 		+=  $totalUpUnitMortages;
			$totalNoaMortages 		+=  $totalNoaUnitMortages;
			$totalOst =  $totalUpUnit+$totalUpUnitMortages;
			
			$transaction = array(
				'id_unit'				=> $unit->id,

				'noa_os_mortage_yesterday'		=> $getOstYesterday->noa_os_mortage,
				'os_mortage_yesterday'			=> $getOstYesterday->os_mortage,

				'noa_os_regular_yesterday'		=> $getOstYesterday->noa_os_regular,
				'os_regular_yesterday'			=> $getOstYesterday->os_regular,
			

				'date'					=> $date,				
				'os'				    => $totalOst,
				'noa_regular'			=> $creditToday->noa_regular,
				'up_regular'			=> $creditToday->up_regular,
				'noa_repyment_regular'	=> $repaymentToday->noa_regular,
				'repyment_regular'		=> $repaymentToday->up_regular,
				'noa_os_regular'		=> $totalNoaUnit,
				'os_regular'			=> $totalUpUnit,
				'noa_mortage'			=> $creditToday->noa_mortage,
				'up_mortage'			=> $creditToday->up_mortage,
				'noa_repayment_mortage'	=> $repaymentToday->noa_mortage,
				'repayment_mortage'		=> $repaymentToday->up_mortage,
				'noa_os_mortage'		=> $totalNoaUnitMortages,
				'os_mortage'			=> $totalUpUnitMortages,
				'noa_real_reguler'		=> $realos->noaReg,
				'os_real_reguler'		=> $realos->osReg,
				'noa_real_mortage'		=> $realos->noaNonReg,
				'os_real_mortage'		=> $realos->osNonReg,
				'real_outstanding'		=> $realos->outstanding,
			);
			$dpddate = date('Y-m-d', strtotime($date));		
			$mindate = date('Y-m-d', strtotime($date.' -1 days'));
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $dpddate);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $mindate);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$dpddate);
			$unit->dpd_repayment_Deadline = $this->regular->getRepaymentDeadline($unit->id,$dpddate);
			

			$dpdYesterday =  $this->model
			->db->order_by('date','desc')->get_where('units_dpd',array('id_unit' => $unit->id,'date <'=>$date))->row();
			
			
			$noaYesterday = $dpdYesterday ?
			$dpdYesterday->total_noa
			 : $unit->dpd_yesterday->noa;

			$ostYesterday =   $dpdYesterday ? $dpdYesterday->total_up : 
			 $unit->dpd_yesterday->ost;
			 
			 
	        $os =  $this->model
			->db->select('sum(amount) as os, count(*) as noa')
			->from('units_regularpawns')
			->where('deadline <=', $date)
			->where('id_unit', $unit->id)
			->where('status_transaction','N')
			->get()->row();
            
			$total_dpd = array(
				'id_unit'	=> $unit->id,
				'date'	=> $date,
				'noa_yesterday'	=> $noaYesterday,
				'ost_yesterday'	=> $ostYesterday,
				'noa_today'	=> $unit->dpd_today->noa,
				'ost_today'	=> $unit->dpd_today->ost,
				'noa_repayment'	=> $unit->dpd_repayment_today->noa,
				'ost_repayment'	=> $unit->dpd_repayment_today->ost,
		    	'total_noa'		=> abs($noaYesterday +  $unit->dpd_today->noa- $unit->dpd_repayment_today->noa),
				'total_up'		=> abs($ostYesterday + $unit->dpd_today->ost -  $unit->dpd_repayment_today->ost),
					'os'	=> $totalOst,
			);
			
			$total_dpd['percentage'] = round(($total_dpd['total_up'] / $total_dpd['os'])*100,2);
			
			$checkDpd = $this->model
				->db->get_where('units_dpd',array('id_unit' => $unit->id,'date'=>$date));
			if($checkDpd->num_rows() > 0){
				$this->model->db->update('units_dpd', $total_dpd, array('id_unit' => $unit->id,'date'=>$date));
			}else{
				$this->model->db->insert('units_dpd', $total_dpd);
			}

			//echo "<pre/>";
			//print_r($transaction);
			$check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$date));
			if($check->num_rows() > 0){
				//$this->model->db->update('units_outstanding', $transaction, array('id_unit' => $unit->id,'date'=>$date));
				$this->model->db->update('units_outstanding', $transaction, array('id_unit' => $unit->id,'date'=>$date,'noa_real_reguler'=>$realos->noaReg,'os_real_reguler'=>$realos->osReg,'noa_real_mortage'=>$realos->noaNonReg,'os_real_mortage'=>$realos->osNonReg,'real_outstanding'=>$realos->outstanding));
			}else{
				$this->model->db->insert('units_outstanding', $transaction);
			}			
		}

		echo json_encode(
			array(
				'Noa Regular'	=> number_format($totalNoa,0).'<br>',
				'Outstanding Regular'	=> number_format($totalUp,0).'<br>',
				'Booking Regular'	=> number_format($totalPencairan,0).'<br>',
				'Pelunasan Regular'	=>  number_format($totalPelunasan,0).'<br>',

				'Noa Cicilan'	=> number_format($totalNoaMortages,0).'<br>',
				'Outstanding Cicilan'	=> number_format($totalUpMortages,0).'<br>',
				'Booking Cicilan'	=> number_format($totalPencairanMortages,0).'<br>',
				'Pelunasan Cicilan'	=>  number_format($totalPelunasanMortages,0).'<br>',
			)
		);

		echo "<br/>";
		$this->repairtransaction();


	}
	
	public function dpdrepair(){

		if($date = $this->input->get('date')){
			$date = $date;
		}else{
			$date = date('Y-m-d');
		}

		$units = $this->units->db->select('units.id, units.name, area')
				 ->join('areas','areas.id = units.id_area')
				 ->order_by('units.id','desc')
				 ->get('units')->result();

		foreach ($units as $unit){
			$getReg = $this->regular->db->select('sum(amount) as up,count(id) as noa')
			             ->from('units_regularpawns')
						 ->where('units_regularpawns.status_transaction ','N') 
						 ->where('units_regularpawns.amount !=','0') 
						 ->where('units_regularpawns.deadline <=',$date) 
						 ->where('units_regularpawns.id_unit ',$unit->id) 
						 ->get()->row();

			$data = array(				
				'date'		=> $date,
				//'id_unit'	=> $unit->id
				//'unit'		=> $unit->name,
				'total_up '	=> (int) $getReg->up,
				'total_noa'	=> (int) $getReg->noa,				
				);

				$check = $this->db->get_where('units_dpd',array('id_unit' => $unit->id,'date'=>$date));
				if($check->num_rows() > 0){
					$this->db->update('units_dpd', $data, array('id_unit' => $unit->id,'date'=>$date));
				}else{
					$this->db->insert('units_dpd', $data);
				}

				echo '<pre>';
				print_r($data);
		}

		//echo '<pre>';
		//print_r($units);

	}
	
	public function getos(){

		if($date = $this->input->get('date')){
			$date = $date;
		}else{
			$date = date('Y-m-d');
		}		

		$units = $this->units->db->select('units.id, units.name, area')
				->join('areas','areas.id = units.id_area')
				->order_by('units.id','asc')
				->get('units')->result();

		foreach ($units as $unit){	
			$os 	= $this->regular->getRealOS($unit->id,$date);
			$summary = array(
				'id_unit'				=> $unit->name,
				'date'					=> $date,				
				'noa_real_reguler'		=> $os->noaReg,
				'os_real_reguler'		=> $os->osReg,
				'noa_real_mortage'		=> $os->noaNonReg,
				'os_real_mortage'		=> $os->osNonReg,
				'real_outstanding'		=> $os->outstanding,
			);	
			
			echo"<pre/>";
			print_r($summary);
		}

	}

}
