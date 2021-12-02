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
class Home extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function testimonials_get()
    {
        $testimonials = $this->db->query("SELECT c.NOMBRE as `name`, e.NOMBRE as `state`, case when c.CONTADO='S' then 'Cliente General' else (case when (c.CONTADO='N' AND c.SOLO_VTA_CONTADO='S') then 'Cliente Distribuidor' else
		'Ciente Credito' end) end as `type`, wr.* FROM web_review wr
			INNER JOIN pedidos_web2 pw ON wr.pedidos_web_id = pw.pedidos_web_id 
			INNER JOIN `_CLIENTES` c ON pw.CLIENTE_ID = c.CLIENTE_ID 
			LEFT JOIN `_DIRS_CLIENTES` dc on pw.DIR_CONSIG_ID = dc.DIR_CLI_ID 
			INNER JOIN `_ESTADOS` e on dc.ESTADO_ID = e.ESTADO_ID
			WHERE wr.upload = 'S' ORDER BY wr.date_time_create DESC")->result();

        $this->response($testimonials, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
