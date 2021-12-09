<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class PostalCode extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['store_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['destroy_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get() {
        $cp = $this->input->get('cp', TRUE);
        $postal_codes = array();
        if (!empty($cp)) {
            $postal_codes = $this->db->query("SELECT * FROM postal_codes WHERE cp='{$cp}'")->row();
        } else {
            $postal_codes = $this->db->query("SELECT * FROM postal_codes")->result();
        }

        $this->response(array(
            'status' => true,
            'message' => 'postal codes retrieved sucessfully',
            'data' => $postal_codes
        ), \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
    
    public function store_post() {

        $parameters = json_decode(file_get_contents('php://input'), true);

        $this->response(array(
            'status' => true,
            'message' => 'postal codes retrieved sucessfully',
            'data' => $parameters['codes']
        ), \Restserver\Libraries\REST_Controller::HTTP_OK);

        // $codes = json_decode($request->codes, true);
        // collect($codes)->each(function ($items){
        //     PostalCode::updateOrCreate([
        //         'cp' => $items['cp'],
        //         'settlement' =>  $items['settlement'],
        //         'settlement_type' =>  $items['settlement_type'],
        //         'municipality' =>  $items['municipality'],
        //         'state' =>  $items['state'],
        //         'city' =>  $items['city'],
        //         'country' =>  $items['country']
        //     ]);
        // });


    }

    public function destroy_delete() {

    }
    
}
