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
class Location extends \Restserver\Libraries\REST_Controller
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['location_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['location_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['location_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function findByCity_get() {
       
        //sanear_string
        $nameState = sanear_string($this->input->get('name_state', TRUE));
        $nameCity = sanear_string($this->input->get('name_city', TRUE));
        $dataState = $this->db->query("SELECT * FROM `_ESTADOS` e WHERE e.NOMBRE='{$nameState}'")->row();
        
        if (!empty($dataState)) {
            $city = $this->db->query("SELECT CIUDAD_ID FROM _CIUDADES WHERE NOMBRE LIKE '%" . strtoupper($nameCity) . "%' AND ESTADO_ID = {$dataState->ESTADO_ID} LIMIT 1")->row();            
            $locations = $this->db->query("SELECT * FROM _LOCALIDADES WHERE CIUDAD_ID = {$city->CIUDAD_ID}")->result();
            $this->response(array(
                'status' => true,
                'message' => 'Locations retrieved sucessfully',
                'data' => $locations
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);

        } else {
            $this->response(array(
                'status' => false,
                'message' => 'Locations not found',
                'data' => array()
            ), 200 /*\Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED*/);            
        }
    }
}
