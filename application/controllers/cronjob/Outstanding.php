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
		$this->load->model('MortagesModel', 'mortages');		
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
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('units.id','desc')
			->get('units')->result();
		$totalUp = 0;
		$totalNoa = 0;
		$totalPelunasan = 0;
		$totalPencairan = 0;
		foreach ($units as $unit){
			$getOstYesterday = $this->model->db
				->where('date <', $date)
				->from('units_outstanding')
				->where('id_unit', $unit->id)
				->order_by('date','DESC')
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
				'date'	=> $date,
				'noa'	=> $totalOstToday['noa'],
				'os'	=> $totalOstToday['up'],
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

	public function generate(){

		if($date = $this->input->get('date')){
			$date = $date;
		}else{
			$date = date('Y-m-d');
		}

		//$date = '2020-10-27';
		$totalUp = 0;
		$totalNoa = 0;
		$totalPelunasan = 0;
		$totalPencairan = 0;

		$totalUpMortages = 0;
		$totalNoaMortages = 0;
		$totalPelunasanMortages = 0;
		$totalPencairanMortages = 0;

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('units.id','desc')
			->get('units')->result();

		foreach ($units as $unit){
			$creditToday 	= $this->regular->getCreditToday($unit->id, $date);
			$repaymentToday = $this->regular->getRepaymentToday($unit->id, $date);
			$getOS 			= $this->regular->getOutstanding($unit->id, $date);
			
			$transaction = array(
				//'area'					=> $unit->area,
				//'unit'					=> $unit->name,
				'id_unit'				=> $unit->id,
				'date'					=> $date,
				//reguler
				'noa_regular'			=> $creditToday->noa_regular,
				'up_regular'			=> $creditToday->up_regular,
				'noa_repyment_regular'	=> $repaymentToday->noa_regular,
				'repyment_regular'		=> $repaymentToday->up_regular,
				'noa_os_regular'		=> $getOS->noa_os_regular,
				'os_regular'			=> $getOS->os_regular,
				//cicilan
				'noa_mortage'			=> $creditToday->noa_mortage,
				'up_mortage'			=> $creditToday->up_mortage,
				'noa_repayment_mortage'	=> $repaymentToday->noa_mortage,
				'repayment_mortage'		=> $repaymentToday->up_mortage,
				'noa_os_mortage'		=> $getOS->noa_os_mortage,
				'os_mortage'			=> $getOS->os_mortage,
			);

			$totalUp +=  $getOS->os_regular;
			$totalNoa +=  $getOS->noa_os_regular;
			$totalPelunasan +=  $repaymentToday->up_regular;
			$totalPencairan +=  $creditToday->up_regular;

			$totalUpMortages +=  $getOS->os_mortage;
			$totalNoaMortages +=   $getOS->noa_os_mortage;
			$totalPelunasanMortages +=  $repaymentToday->up_mortage;
			$totalPencairanMortages +=  $creditToday->up_mortage;


			//echo "<pre/>";
			//print_r($transaction);
			$check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$date));
			if($check->num_rows() > 0){
				$this->db->update('units_outstanding', $transaction, array('id_unit' => $unit->id,'date'=>$date));
			}else{
				$this->db->insert('units_outstanding', $transaction);
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
	}

}
