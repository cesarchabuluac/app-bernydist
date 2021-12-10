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

    public function index_get()
    {
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

    public function show_get()
    {
        $cp = $this->input->get('cp', TRUE);
        $postal_code = $this->db->query("SELECT * FROM postal_codes WHERE cp='{$cp}'")->row();
        if (empty($postal_code)) {
            $this->response(array(
                'status' => false,
                'message' => 'postal code not found',
                'data' => []
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'status' => true,
                'message' => 'postal code retrieved sucessfully',
                'data' => $postal_code
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    public function store_post()
    {

        $parameters = json_decode(file_get_contents('php://input'), true);

        if (!empty($parameters)) {
            $data = $this->db->insert_batch('postal_codes', $parameters);

            $this->response(array(
                'status' => true,
                'message' => 'postal codes saved sucessfully',
                'data' => $data
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'status' => false,
                'message' => 'postal codes retrieved sucessfully',
                'data' => []
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    public function destroy_delete()
    {
    }
}
