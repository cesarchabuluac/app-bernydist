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
class Auth extends \Restserver\Libraries\REST_Controller
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

    /**
     * Index method for completeness. Returns a JSON response with an
     * error message.
     */
    public function index_get()
    {
        header('Content-Type: application/json');
        echo json_encode(array(
            "code" => BAD_DATA,
            "message" => "No resource specified."
        ));
    }

    public function login_post()
    {
        // header('Content-Type: application/json');
        // if ($this->input->method(true) != 'POST') {
        //     echo json_encode(array("message:" => "Use the HTTP POST method to login to the system."));
        //     return;
        // } else{
          
        // }

        
    }
}
