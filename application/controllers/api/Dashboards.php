<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Dashboards extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('RepaymentModel','repayments');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('OutstandingModel', 'outstanding');

		
	}

	public function outstanding()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($id_unit = $this->input->get('id_unit')){
			$this->units->db->where('units.id', $id_unit);
		}else if($code = $this->input->get('code')){
			$this->units->db->where('code', zero_fill($code, 3));
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
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
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id);
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $date);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $date);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			$unit->total_dpd = (object) array(
				'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa - $unit->dpd_repayment_today->noa,
				'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function disburseytd()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('year')){
			$year = $this->input->get('year');
		}else{
			$year = date('Y');
		}
		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getTotalDisburse($unit->id, $year)->credit;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function disbursemtd()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('year')){
			$year = $this->input->get('year');
		}else{
			$year = date('Y');
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
		}else{
			$month = date('n');
		}

		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getTotalDisburse($unit->id, $year, $month)->credit;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function pencairan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('units.id', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$now = $date;
		$begin = new DateTime( $date );
		$end = new DateTime($date);
		$end = $end->modify( '-6 day' );
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($end, $interval ,$begin);

		$dates = array();
		foreach($daterange as $date){
			$dates[] =  $date->format('Y-m-d');
		}

		$result[] = array('no' => 'No','unit'=> 'Unit','area'=>'Area','dates'=>$dates);
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$dates = array();
			foreach($daterange as $date){
				$dates[] =  $this->regular->getUpByDate($unit->id, $date->format('Y-m-d'));
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		$this->sendMessage($result, 'Get Data Outstanding');
	}

	public function pencairandashboard()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getUpByDate($unit->id, $date);
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function pelunasandashboard()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		if($this->input->get('month')){
			$date = $this->input->get('month');
		}
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->repayments->getUpByDate($unit->id, $date);
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function pelunasan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('units.id', $code);
		}
		if($id_unit = $this->input->get('id_unit')){
			$this->units->db->where('units.id', $id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$begin = new DateTime( $date );
		$end = new DateTime($date);
		$end = $end->modify( '-6 day' );
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($end, $interval ,$begin);

		$dates = array();
		foreach($daterange as $date){
			$dates[] =  $date->format('Y-m-d');
		}

		$result[] = array('no' => 'No','unit'=> 'Unit','area'=>'Area','dates'=>$dates);
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$dates = array();
			foreach($daterange as $date){
				$dates[] =  $this->repayments->getUpByDate($unit->id, $date->format('Y-m-d'));
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		$this->sendMessage($result, 'Get Data Outstanding');
	}

	public function pendapatan()
	{
		$listperk = $this->m_casing->get_list_pendapatan();
		$category=array();
		foreach ($listperk as $value) {
			array_push($category, $value->no_perk);
		}
		
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		
		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
			$this->units->db->where('date', $date);
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
			$this->units->db->where('MONTH(date)', $month);
		}

		$this->units->db->select('units.name, sum(amount) as amount')
			->join('units','units.id = units_dailycashs.id_unit')
			->from('units_dailycashs')
			->where('type','CASH_IN')	
			->where_in('no_perk', $category)
			->group_by('units.name')
			->order_by('amount','desc');
		$data = $this->units->db->get()->result();
		return $this->sendMessage($data,'Successfully get Pendapatan');
	}

	public function pengeluaran()
	{
		$listperk = $this->m_casing->get_list_pengeluaran();
		$category=array();
		foreach ($listperk as $value) {
			array_push($category, $value->no_perk);
		}
		
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}

		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
			$this->units->db->where('date', $date);
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
			$this->units->db->where('MONTH(date)', $month);
		}
		
		$this->units->db->select('units.name, sum(amount) as amount')
			->join('units','units.id = units_dailycashs.id_unit')
			->from('units_dailycashs')
			->where('type','CASH_OUT')
			->where_in('no_perk', $category)
			->group_by('units.name')
			->order_by('amount','desc');
		$data = $this->units->db->get()->result();
		return $this->sendMessage($data,'Successfully get Pendapatan');
	}

	public function saldo()
	{
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}

		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
			$this->units->db->where('date', $date);
		}
		if($this->input->get('month')){
			$month = $this->input->get('month');
			$this->units->db->where('MONTH(date)', $month);
		}

		$this->units->db->select('units.name, (sum(CASE WHEN type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN type = "CASH_OUT" THEN `amount` ELSE 0 END)) as amount')
			->join('units','units.id = units_dailycashs.id_unit')
			->from('units_dailycashs')
			->group_by('units.name')
			->order_by('amount','desc');
		$data = $this->units->db->get()->result();
		return $this->sendMessage($data,'Successfully get Pendapatan');
	}

	public function dpd()
	{
		if($this->input->get('date_end')){
			$date_end = $this->input->get('date_end');
		}else{
			$date_end = date('Y-m-d');
		}
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}

		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		$this->units->db->select('name,sum(amount) as up')
			->join('units','units.id = units_regularpawns.id_unit')
			->join('areas','areas.id = units.id_area')
			->from('units_regularpawns')
			->where('deadline <=',$date_end)
			->where('units_regularpawns.date_sbk <=', $date_end)
			->where('units_regularpawns.status_transaction','N')
			->group_by('units.name')
			->order_by('up','desc');
		$data = $this->units->db->get()->result();
		return $this->sendMessage($data,'Successfully get Pendapatan');
	}

	public function disburse()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('year')){
			$year = $this->input->get('year');
		}else{
			$year = date('Y');
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
		}else{
			$month = date('n');
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('d');
		}

		$units = $this->units->db->select('units.id, units.name, units.id_area')->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getTotalDisburse($unit->id, $year, $month, $date)->credit;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function newoutstanding()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			 $unit->ost_yesterday = $this->regular->getOstYesterday_($unit->id, $date);			
			 $unit->ost_today = $this->regular->getOstToday_($unit->id, $date);					 
			 
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function bookcash()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$this->regular->db->where('id_unit', $idUnit);		
		$data = $this->regular->db->order_by('id','DESC')->get('units_cash_book')->row();
		$data->noa = (int) $this->regular->db
			->select('count(*) as noa')
			->from('units_regularpawns')
			->where('id_unit', $idUnit)
			->get()->row()->noa;
		return $this->sendMessage($data,'Get Book Cash Daily');
	}

	public function unitbooking()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('date_sbk',$date)
			->get()->row();
		$last = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('date_sbk',$dateLast)
			->get()->row();
		$data = new stdClass();
		$data->today_noa = (int) $today->noa;
		$data->today_up = (int) $today->up;
		$data->last_noa = (int) $last->noa;
		$data->last_up = (int) $last->up;
		$data->total_noa = $data->today_noa + $data->last_noa;
		$data->total_up = $data->today_up + $data->last_up;
		return $this->sendMessage($data,'Get Unit Booking');
	}
	
	public function unitost()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('date_sbk',$date)
			->where('status_transaction',"N")
			->get()->row();
		$last = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('date_sbk <',$dateLast)			
			->where('status_transaction',"N")
			->get()->row();
		$data = new stdClass();
		$data->today_noa = (int) $today->noa;
		$data->today_up = (int) $today->up;
		$data->last_noa = (int) $last->noa;
		$data->last_up = (int) $last->up;
		$data->total_noa = $data->today_noa + $data->last_noa;
		$data->total_up = $data->today_up + $data->last_up;
		return $this->sendMessage($data,'Get Unit Booking');
	}

	public function unitdpd()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('deadline',$date)
			->where('status_transaction',"N")
			->get()->row();
		$last = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('deadline <',$date)			
			->where('status_transaction',"N")
			->get()->row();
		$data = new stdClass();
		$data->today_noa = (int) $today->noa;
		$data->today_up = (int) $today->up;
		$data->last_noa = (int) $last->noa;
		$data->last_up = (int) $last->up;
		$data->total_noa = $data->today_noa + $data->last_noa;
		$data->total_up = $data->today_up + $data->last_up;
		return $this->sendMessage($data,'Get Unit Booking');
	}

	public function unitpencairan()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->get()->row();
		$last = $this->regular->db
			->select('count(*) as noa, sum(amount_loan) as up')
			->from('units_mortages')
			->where('id_unit',$idUnit)		
			->get()->row();
		$data = new stdClass();
		$data->reg_noa = (int) $today->noa;
		$data->reg_up = (int) $today->up;
		$data->mor_noa = (int) $last->noa;
		$data->mor_up = (int) $last->up;
		$data->total_noa = $data->reg_noa + $data->mor_noa;
		$data->total_up = $data->reg_up + $data->mor_up;
		return $this->sendMessage($data,'Get Unit Booking');
	}

	public function unitpelunasan()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('count(*) as noa, sum(amount) as up')
			->from('units_regularpawns')
			->where('id_unit',$idUnit)
			->where('status_transaction','L')
			->get()->row();
		$last = $this->regular->db
			->select('count(*) as noa, sum(amount_loan) as up')
			->from('units_mortages')
			->where('id_unit',$idUnit)		
			->where('status_transaction','L')		
			->get()->row();
		$data = new stdClass();
		$data->reg_noa = (int) $today->noa;
		$data->reg_up = (int) $today->up;
		$data->mor_noa = (int) $last->noa;
		$data->mor_up = (int) $last->up;
		$data->total_noa = $data->reg_noa + $data->mor_noa;
		$data->total_up = $data->reg_up + $data->mor_up;
		return $this->sendMessage($data,'Get Unit Booking');
	}

	public function unitprofit()
	{
		$idUnit = $this->session->userdata('user')->id_unit;
		$date = $this->input->get('date');
		if(is_null($date)){
			$date = date('Y-m-d');
		}
		$dateLast = date('Y-m-d', strtotime($date. ' -1 Days'));
		$today = $this->regular->db
			->select('sum(amount) as up')
			->from('units_dailycashs')
			->where('id_unit',$idUnit)
			->where('type','CASH_IN')
			->get()->row();
		$last = $this->regular->db
			->select('sum(amount) as up')
			->from('units_dailycashs')
			->where('id_unit',$idUnit)		
			->where('type','CASH_OUT')		
			->get()->row();
		$data = new stdClass();
		$data->cash_in = (int) $today->up;
		$data->cash_out = (int) $last->up;
		$data->total_up = $data->cash_in + $data->cash_out;
		return $this->sendMessage($data,'Get Unit Booking');
	}

	public function saldounit()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('id_unit')){
			$this->units->db->where('id_unit', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}

		$this->units->db
			->select('id_unit, name, amount, cut_off')
			->DISTINCT ('id_unit')
			->from('units_saldo')
			->join('units','units.id = units_saldo.id_unit');
		$getSaldo = $this->units->db->get()->result();
		foreach ($getSaldo as $get){
			$this->units->db->select('(sum(CASE WHEN type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN type = "CASH_OUT" THEN `amount` ELSE 0 END)) as amount')
				->join('units','units.id = units_dailycashs.id_unit')
				->from('units_dailycashs')
				->where('units.id', $get->id_unit)
				->where('units_dailycashs.date >',$get->cut_off);
			$data = $this->units->db->get()->row();
			if($data){
				$get->amount = $get->amount + $data->amount;
			}
		}

		return $this->sendMessage($getSaldo,'Successfully get Pendapatan');
	}

	public function totoutstanding()
	{
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		
		$date = date('Y-m-d', strtotime($date));
		$lastdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
		
		$outsanding['today'] =$this->outstanding->getOs($date)->today; 
		$outsanding['yesterday'] = $this->outstanding->getOs($lastdate)->yesterday;

		return $this->sendMessage($outsanding,'Successfully get Pendapatan');
	}

}
