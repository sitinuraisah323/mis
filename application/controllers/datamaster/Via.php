<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Via extends Authenticated
 {
    /**
    * @var string
    */

    public $menu = 'Via';

    /**
    * Welcome constructor.
    */

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'ViaModel', 'via' );
        $this->load->model( 'PaymentsModel', 'payments' );

    }

    /**
    * Welcome Index()
    */

    public function index()
 {
    $data['payments'] = $this->payments->all();

        $this->load->view( 'via/index', $data );
    }

}
