<?php

require_once APPPATH.'controllers/api/ApiController.php';

class Payments extends ApiController
 {

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'PaymentsModel', 'payments' );
    }

    public function index()
 {
        $data = $this->payments->all();
        if ( $post = $this->input->post() ) {
            if ( is_array( $post['query'] ) ) {
                $value = $post['query']['generalSearch'];
                $this->payments->db
                ->or_like( 'jenis', strtoupper( $value ) );

                $data = $this->payments->all();
            }
        }

        echo json_encode( array(
            'data'	 => $data,
            'status' => true,
            'message'=> 'Successfully Get Data Payments'
        ) );
    }

    public function get_byid()
 {
        echo json_encode( array(
            'data'	=> 	$this->payments->find($this->input->get("id")),
            'status'	=> true,
            'message'	=> 'Successfully Get Data Payments'
        ) );
    }

    public function insert()
 {
        if ( $post = $this->input->post() ) {

            $data['jenis'] = $this->input->post( 'jenis' );

            $db = false;
            $db = $this->payments->insert( $data );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Insert Data Payments'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Insert Data Payments'
                ) );
            }
        }

    }

    public function update()
 {
        if ( $post = $this->input->post() ) {

            $id = $this->input->post( 'id' );

            $data['jenis'] = $this->input->post( 'jenis' );

            $db = false;
            $db = $this->payments->update( $data, $id );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Update Data Payments'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Update Data Payments'
                ) );
            }
        }

    }

    public function delete()
 {
        if ( $post = $this->input->get() ) {

            $data['id'] = $this->input->get( 'id' );

            $db = false;
            $db = $this->payments->delete( $data );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Delete Data Payments'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Delete Data Payments'
                ) );
            }
        }

    }

}
