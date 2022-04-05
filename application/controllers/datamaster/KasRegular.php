<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class KasRegular extends Authenticated
 {
    /**
    * @var string
    */

    public $menu = 'KasRegular';

    /**
    * Welcome constructor.
    */

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'UnitsdailycashModel', 'kas' );
        $this->load->model( 'RegularpawnsModel', 'regular' );
    }

    /**
    * Welcome Index()
    */

    public function index()
 {
        $this->load->view( 'kasregular/index' );
    }

}
