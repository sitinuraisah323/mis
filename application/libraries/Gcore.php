<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gcore {

    protected $CI;

    // public $api_client_secret;

    // public $api_client_id;

    public $url;

    // public $token;

    public function __construct()
    {
        // exit;
        $this->CI =& get_instance();
        $this->CI->config->load('gcore');
        // $this->api_client_id = $this->CI->config->item('api_client_id');
        // $this->api_client_secret = $this->CI->config->item('api_client_secret');
        $this->url_master = $this->CI->config->item('url_master');
        $this->url_transaction = $this->CI->config->item('url_transaction');
        $this->url_pendapatan = $this->CI->config->item('url_pendapatan');
        // $this->token = $this->login()->access_token;
            // Do something with $params
    }

    public function login()
    {
         //Initialize Header
        $urlLogin = $this->url.'/oauth/token';

        $ch = curl_init();

        $form =  "grant_type=client_credentials&scope=api";

        $form .= "&client_id=".$this->api_client_id;
        $form .= "&client_secret=".$this->api_client_secret;


        curl_setopt($ch, CURLOPT_URL,$urlLogin);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                   $form);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        
        
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $res = json_decode(curl_exec ($ch));
        
        curl_close ($ch);

        return $res;
        
    }

    public function transaction($date, $area, $cabang, $unit)
    {
           $url = $this->url_transaction.'/api/v1/transactions/ghanet_report/';
        // var_dump($url); exit;

           $date = $date ?  $date : date('Y-m-d');
            // $date = $date;
           $area = $area ?  $area : '';
           $cabang = $cabang ?  $cabang : '';
           $unit = $unit ?  $unit : '';
           
           

           $dataArray = array(
               'date'   => $date,
               'unit_id' => $unit,
               'branch_id' => $cabang,
               'area_id' => $area

           );

           $data = http_build_query($dataArray);

           $getUrl = $url."?".$data;
           $crl = curl_init($getUrl);

           $headr = array();
           $headr[] = 'Content-type: application/json';
        //    $headr[] = 'Authorization: Bearer '.$this->token;
           curl_setopt($crl, CURLOPT_URL,$getUrl);
           curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
           curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
                            
           $res = curl_exec($crl);

        //    $httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

        //     if ( $httpCode != 200 ){
        //         echo "Return code is {$httpCode} \n"
        //             .curl_error($crl);
        //     } else {
        //         echo "<pre>".htmlspecialchars($res)."</pre>";
        //     }
           curl_close($crl);  
        // var_dump($res); exit;

           return json_decode($res);
    }

     public function pendapatan($dateStart = '', $dateEnd = '', $unitname = '', $transactionStatus, $page = 1)
    {
        $url = $this->url_pendapatan.'/api/v1/revenues.json/';
        $dataArray = array(
        );
        if($dateStart){
            $dataArray['date'] = $dateStart;
        }
        if($page){
            $dataArray['page'] = $page;
        }
        // if($dateEnd){
        //     $dataArray['end_date'] = $dateEnd;
        // }
        // if($transactionStatus){
        //     $dataArray['transaction_status'] = $transactionStatus;
        // }
        if($unitname){
            $dataArray['unit_office_name'] = $unitname;
        }
        $data = http_build_query($dataArray);

           $getUrl = $url."?".$data;
           $crl = curl_init($getUrl);

           $headr = array();
           $headr[] = 'Content-type: application/json';
        //    $headr[] = 'Authorization: Bearer '.$this->token;
           curl_setopt($crl, CURLOPT_URL,$getUrl);
           curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
           curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
                            
           $res = curl_exec($crl);

        //    $httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

        //     if ( $httpCode != 200 ){
        //         echo "Return code is {$httpCode} \n"
        //             .curl_error($crl);
        //     } else {
        //         echo "<pre>".htmlspecialchars($res)."</pre>";
        //     }
           curl_close($crl);  
        // var_dump($res); exit;

           return json_decode($res);
    }

    

    public function areas()
    {
        $url = $this->url_master.'/api/v1/areas/autocomplete';
        $dataArray = array(
            'limit' => '50'
        );
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        // $headr[] = 'Authorization: Bearer '.$this->token;
        curl_setopt($crl, CURLOPT_URL,$getUrl);
        curl_setopt($crl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // return the transfer as a string 
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        $res = curl_exec($crl);
        // var_dump($res); exit;
        // $httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

        //     if ( $httpCode != 200 ){
        //         echo "Return code is {$httpCode} \n"
        //             .curl_error($crl);
        //     } else {
        //         echo "<pre>".htmlspecialchars($res)."</pre>";
        //     }
            
        curl_close($crl);  
        return json_decode($res);
    }

    public function getareas($area)
    {
        $url = $this->url_master.'/api/v1/areas/autocomplete';
        $dataArray = array(
            'limit' => '50',
            'area_id' => $area
        );
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        // $headr[] = 'Authorization: Bearer '.$this->token;
        curl_setopt($crl, CURLOPT_URL,$getUrl);
        curl_setopt($crl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // return the transfer as a string 
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        $res = curl_exec($crl);
        // var_dump($res); exit;
        // $httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);

        //     if ( $httpCode != 200 ){
        //         echo "Return code is {$httpCode} \n"
        //             .curl_error($crl);
        //     } else {
        //         echo "<pre>".htmlspecialchars($res)."</pre>";
        //     }
            
        curl_close($crl);  
        return json_decode($res);
    }

    public function branchies($areaId)
    {
        $url = $this->url_master.'/api/v1/branch_offices/autocomplete';
        $dataArray = array(
            'limit'   => '50',        
            'area_id'   => $areaId
        );
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        // $headr[] = 'Authorization: Bearer '.$this->token;
        curl_setopt($crl, CURLOPT_URL,$getUrl);
        curl_setopt($crl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // return the transfer as a string 
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        $res = curl_exec($crl);
        curl_close($crl);  
        return json_decode($res);
    }

    public function units($branch_id)
    {
        $url = $this->url_master.'/api/v1/unit_offices/autocomplete';
        $dataArray = array(
            'branch_office_id'   => $branch_id
        );
        $data = http_build_query($dataArray);
        $getUrl = $url."?".$data;
        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        // $headr[] = 'Authorization: Bearer '.$this->token;
        curl_setopt($crl, CURLOPT_URL,$getUrl);
        curl_setopt($crl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        // return the transfer as a string 
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
        $res = curl_exec($crl);
        curl_close($crl);  
        return json_decode($res);
    }
}