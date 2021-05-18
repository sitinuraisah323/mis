<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Yogadai {

    protected $CI;

    public $api_client_secret;

    public $api_client_id;

    public $url;

    public $token;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('yogadai');
        $this->api_client_id = $this->CI->config->item('api_client_id');
        $this->api_client_secret = $this->CI->config->item('api_client_secret');
        $this->url = $this->CI->config->item('url');
        $this->token = $this->login()->access_token;
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

    public function transaction($date = '')
    {
           $url = $this->url.'/api/v1/publishers/transactions/today';

           $date = $date ?  $date : date('Y-m-d');

           $dataArray = array(
               'date'   => $date
           );

           $data = http_build_query($dataArray);
           $getUrl = $url."?".$data;

           $crl = curl_init();

           $headr = array();
           $headr[] = 'Content-type: application/json';
           $headr[] = 'Authorization: Bearer '.$this->token;
           curl_setopt($crl, CURLOPT_URL,$getUrl);
           curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
           $res = curl_exec($crl);

           return json_decode($res);
    }
}