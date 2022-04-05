<?php

require_once APPPATH.'controllers/api/ApiController.php';

class Via extends ApiController
 {

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'ViaModel', 'via' );
        $this->load->model( 'PaymentsModel', 'via' );
    }

    public function index()
 {
        $data = $this->via->get_jenis();
        if ( $post = $this->input->post() ) {
            if ( is_array( $post['query'] ) ) {
                $value = $post['query']['generalSearch'];
                $this->via->db
                ->or_like( 'via', strtoupper( $value ) );

            }
        }

        $data = $this->via->get_jenis();
        
		echo json_encode(array(
            'data'	=> 	$data,
            'status'=>true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

    public function get_byid()
 {
        echo json_encode( array(
            'data'	=> 	$this->via->find($this->input->get("id")),
            'status'	=> true,
            'message'	=> 'Successfully Get Data Via'
        ) );
    }

    public function insert()
 {
        if ( $post = $this->input->post() ) {

            $data['id_payments'] = $this->input->post( 'id_payments' );
            $data['via'] = $this->input->post( 'via' );

            $db = false;
            $db = $this->via->insert( $data );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Insert Data Via'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Insert Data Via'
                ) );
            }
        }

    }

    public function update()
 {
        if ( $post = $this->input->post() ) {

            $id = $this->input->post( 'id' );
            $data['id_payments'] = $this->input->post( 'id_payments' );
            $data['via'] = $this->input->post( 'via' );

            $db = false;
            $db = $this->via->update( $data, $id );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Update Data Via'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Update Data Via'
                ) );
            }
        }

    }

    public function delete()
 {
        if ( $post = $this->input->get() ) {

            $data['id'] = $this->input->get( 'id' );

            $db = false;
            $db = $this->via->delete( $data );
            if ( $db = true ) {
                echo json_encode( array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Delete Data Via'
                ) );
            } else {
                echo json_encode( array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Delete Data Via'
                ) );
            }
        }

    }

}
