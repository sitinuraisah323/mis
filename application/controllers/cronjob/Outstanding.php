<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
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
        $this->load->model('RegularPawnsModel', 'regular');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $currdate =date("Y-m-d");
        $nextdate = date('Y-m-d', strtotime('+1 days', strtotime($currdate)));
        $lastdate = date('Y-m-d', strtotime('-1 days', strtotime($currdate)));
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			//  $unit->noa = $this->regular->getOstYesterday_($unit->id, $nextdate)->noa;			
         //  $unit->up = $this->regular->getOstYesterday_($unit->id, $nextdate)->up;
          $unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, $currdate);
			 $unit->credit_today = $this->regular->getCreditToday($unit->id, $currdate);
			 $unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $currdate);
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
        $currdate =date("Y-m-d");
        $nextdate = date('Y-m-d', strtotime('+1 days', strtotime($currdate)));
        $lastdate = date('Y-m-d', strtotime('-1 days', strtotime($currdate)));
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			    //$unit->noa = $this->regular->getOstYesterday_($unit->id, $currdate)->noa;			
             //$unit->up = $this->regular->getOstYesterday_($unit->id, $currdate)->up;
             $unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, $currdate);
             $unit->credit_today = $this->regular->getCreditToday($unit->id, $currdate);
             $unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $currdate);
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
   
   public function old()
	{
        $currdate =date("Y-m-d");
        $nextdate = date('Y-m-d', strtotime('+1 days', strtotime($currdate)));
        $lastdate = date('Y-m-d', strtotime('-2 days', strtotime($currdate)));
        $old = date('Y-m-d', strtotime('-3 days', strtotime($currdate)));
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			 $unit->noa = $this->regular->getOstYesterday_($unit->id, $old)->noa;			
             $unit->up = $this->regular->getOstYesterday_($unit->id, $old)->up;
             
             $data['id_unit']   = $unit->id;
             $data['date']      = $lastdate;
             $data['noa']       = $unit->noa;
             $data['os']        = $unit->up;
             $check = $this->db->get_where('units_outstanding',array('id_unit' => $unit->id,'date'=>$lastdate));
             if($check->num_rows() > 0){
                $this->db->update('units_outstanding', $data, array('id_unit' => $unit->id,'date'=>$lastdate));
             }else{
                $this->db->insert('units_outstanding', $data);
             }
		}
        
	}

}
