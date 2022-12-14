<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Payments extends Authenticated
 {
    /**
    * @var string
    */

    public $menu = 'Payments';

    /**
    * Welcome constructor.
    */

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'PaymentsModel', 'payments' );
    }

    /**
    * Welcome Index()
    */

    public function index()
 {
        $this->load->view( 'payments/index' );
    }

}
