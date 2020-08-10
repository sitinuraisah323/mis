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
        $lastdate = date('Y-m-d', strtotime('-2 days', strtotime($currdate)));
        $units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){

			 $unit->noa = $this->regular->getOstYesterday_($unit->id, $lastdate)->noa;			
             $unit->up = $this->regular->getOstYesterday_($unit->id, $lastdate)->up;
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
             //echo "<pre/>";
             //print_r($data);			
		}
        
	}

}
