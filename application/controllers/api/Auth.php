<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';

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

        $this->load->model('Authentication');
        $this->load->model('Configurations');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['store_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['destroy_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['login_post']['limit'] = 50; // 50 requests per hour per user/key

        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }

    /**
     * Index method for completeness. Returns a JSON response with an
     * error message.
     */
    // public function index_get()
    // {
    //     header('Content-Type: application/json');
    //     echo json_encode(array(
    //         "code" => BAD_DATA,
    //         "message" => "No resource specified."
    //     ));
    // }

    // public function login_token_post()
    // {

    //     $tokenData['uniqueId'] = '11';
    //     $tokenData['role'] = 'alamgir';
    //     $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
    //     $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
    //     // echo json_encode(array('Token'=>$jwtToken));
    //     $this->response(array(
    //         'status' => true,
    //         'message' => 'Token retrievied successfully',
    //         'data' => $jwtToken
    //     ), \Restserver\Libraries\REST_Controller::HTTP_OK);
    // }

    public function token_get()
    {

        // $parameters = json_decode(file_get_contents('php://input'), true);

        // $jwt = new JWT();
        // $jwtSecretKey = "appBerny";
        // $data = array(
        //     "code" => $parameters['code'],
        //     "password" => $parameters['password'],
        // );

        // $token = $jwt->encode($data, $jwtSecretKey, "HS256");
        // $data['token'] = $token;

        // $this->response(array(
        //     'status' => true,
        //     'message' => 'Token retrievied successfully',
        //     'data' => $data
        // ), \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    /**
     * Login 
     */
    public function login_post()
    {

        $parameters = json_decode(file_get_contents('php://input'), true);

        $code         = $parameters['code'];
        $password     = $parameters['password'];
        $client_url = $parameters['client_url'];
        $is_modal    = $parameters['is_modal'];

        //Valid is email
        $isEmail = filter_var(trim($code), FILTER_VALIDATE_EMAIL);

        //auth
        $auth = $this->Authentication->check_auth($code, $password, $isEmail);

        //validate activated client
        if (!empty($auth)) {

            if ($auth->ESTATUS === 'I') {
                
                $this->response(array(
                    'status' => false,
                    'message' => 'El cliente no esta activado, favor de validar el correo enviado al momento de registrarse!',
                    'data' => []
                ), \Restserver\Libraries\REST_Controller::HTTP_OK);

            } else {

                $tokenData = array(
                    'customer_id' => $auth->CLIENTE_ID,
                    'customer_key' => $auth->CLAVE_CLIENTE,
                    'name' => $auth->NOMBRE,
                    'password' => $auth->pass,
                    'auth' => true,
                    'expiration_at' => date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s').'+ 1 days')),
                );
                
                $jwtToken = $this->objOfJwt->GenerateToken($tokenData);                
                $auth->token = $jwtToken;

                $this->response(array(
                    'status' => true,
                    'message' => 'Customer retrieved sucessfully!',
                    'data' => $auth
                ), \Restserver\Libraries\REST_Controller::HTTP_OK);                

            }
        } else {
            $this->response(array(
                'status' => false,
                'message' => 'Usuario o contraseña incorrecta, favor de verificar sus datos!',
                'data' => []
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    public function currentUser_get() {

        $parameters = json_decode(file_get_contents('php://input'), true);
        $customerID = $parameters['customer_id'];

        $customer  = $this->db->where('CLIENT_ID', $customerID)->get('_CLIENTES')->row();
        // $auth->PCTJ_PRONTOPAGO  = $customer->PCTJ_PRONTOPAGO;

        // //codigo para cargar el stripe customer de la tabla.. si cuenta con uno.
        // $auth->stripe_customer = $this->Configurations->getStripeCustomer($auth->CLIENTE_ID);

        // $resultEmails = $this->db->query("SELECT * FROM _BR_EMAILS_CLIENTES WHERE CLIENTE_ID={$auth->CLIENTE_ID}")->result();
        // $emails = "";
        // foreach ($resultEmails as $row) {
        //     $emails .= $row->EMAIL . ',';
        // }

        // if (strpos($emails, ",")) {
        //     $emails = substr($emails, 0, -1);
        // }

        // $auth->EMAIL = $emails;

        // $resultKeys     = $this->Configurations->getConektaKeys();
        // foreach ($resultKeys as $row) {
        //     if ($row->config_empresa_id == 1 && $row->proveedor == 'C') {
        //         $auth->KEY_BR_PRI = $row->key_privada;
        //         $auth->KEY_BR_PUB = $row->key_publica;
        //     } elseif ($row->config_empresa_id == 1  && $row->proveedor == 'S') {
        //         $auth->KEY_BR_PRI_STRIPE = $row->key_privada;
        //         $auth->KEY_BR_PUB_STRIPE = $row->key_publica;
        //     } elseif ($row->config_empresa_id == 3  && $row->proveedor == 'C') {
        //         $auth->KEY_FE_PRI = $row->key_privada;
        //         $auth->KEY_FE_PUB = $row->key_publica;
        //     } elseif ($row->config_empresa_id == 3  && $row->proveedor == 'S') {
        //         $auth->KEY_FE_PRI_STRIPE = $row->key_privada;
        //         $auth->KEY_FE_PUB_STRIPE = $row->key_publica;
        //     }
        // }

        // //Determine which company runs the web service                
        // $auth->pEmpresa = $this->Configurations->getCompanyConfig();

        // //We check if you have any pending process in orders to finish
        // $auth->PENDIENTES     = $this->db->query("SELECT COUNT(pedidos_web_id) AS pedidos FROM pedidos_web2 WHERE cliente_id={$auth->CLIENTE_ID} AND estatus = 4 AND TOTAL > 0")->row();
        // $auth->COTIZACIONACTUAL = null;
        // $auth->config_empresa_id = "";
        // $auth->CLT_RECOJE       = "";

        // $auth->is_public = ($auth->CONTADO == 'S') ? 1 : 0;
        // $auth->isPickup = 0;
        // $auth->positive_balance = 0;
        // $auth->email_default = explode(',', $auth->EMAIL)[0];
        // $auth->PASS = sha1(md5($auth->PASS));
        // $auth->client_type = 'WG';
        // switch ($customer->TIPO_CLIENTE_ID) {
        //     case '187185':
        //         $auth->client_type = 'CR';
        //         break;
        //     case '187184':
        //         $auth->client_type = 'WG';
        //         break;
        //     case '88721':
        //         $auth->client_type = 'WD';
        //         break;
        //     default:
        //         $auth->client_type = 'WG';
        //         break;
        // }

        // //Get customer discount policies
        // $auth->policy_artcli_id = $this->Configurations->getPolDesctoArtCli($auth->CLIENTE_ID);
        // $auth->policy_artclivol_id = $this->Configurations->getPolDesctoArtCliVol($auth->CLIENTE_ID);

        // $customerType = $this->Configurations->getCustomerType($auth->CLIENTE_ID);
        // $userType = ($auth->is_public === 1) ? "GENERAL" : "DISTRIBUIDOR";

        // if ($customerType->type == "DISTRIBUIDOR" && $auth->TIPO_LOCALIDAD == "0000-0010") {
        //     $userType = "DISTRIBUIDOR_LOC";
        // }

        // if ($customerType->type == "GENERAL" && $auth->TIPO_LOCALIDAD == "0000-0010") {
        //     $userType = "GENERAL_LOC";
        // }

        // $auth->user_type = $customerType->type;
        // $auth->discount_range = $this->Configurations->getDiscountRange($userType);
        // $factor = ($auth->discount_range->final_percentage - $auth->discount_range->initial_percentage) / 5;

        // //main address
        // $auth->main_address = $this->Configurations->getCustomerEmails($auth->CLIENTE_ID);
        // $auth->main_address->emails = $this->db->where('CLIENTE_ID', $auth->CLIENTE_ID)->get('_BR_EMAILS_CLIENTES')->result();

        // //Shipping addresses
        // $auth->shipping_addresses = $this->db->query("SELECT ROW_NUMBER() OVER ( ORDER BY dc.DIR_CLI_ID ASC) Fila, dc.*, c.NOMBRE AS ciudad, e.NOMBRE AS estado, p.NOMBRE AS pais, l.NOMBRE_LOCALIDAD AS localidad 
        //     FROM `_DIRS_CLIENTES` dc 
        //     LEFT JOIN `_CIUDADES` c ON dc.CIUDAD_ID = c.CIUDAD_ID 
        //     LEFT JOIN `_ESTADOS` e ON dc.ESTADO_ID = e.ESTADO_ID 
        //     LEFT JOIN `_PAISES` p ON dc.PAIS_ID = p.PAIS_ID 
        //     LEFT JOIN `_LOCALIDADES` l ON dc.LOCALIDAD_ID = l.LOCALIDAD_ID 
        //     WHERE dc.CLIENTE_ID = {$auth->CLIENTE_ID} GROUP BY dc.DIR_CLI_ID")->result();


        // //Check catalog view
        // if (!$auth->is_public) {
        //     $exists = $this->Configurations->getCustomerSetting($auth->CLIENTE_ID, "setting_view");
        //     $data = array(
        //         'exists' => !empty($exists) ? 1 : 0,
        //         'customer_id' => $auth->CLIENTE_ID,
        //         'setting_type' => "setting_view",
        //         'setting_value' => 1,
        //     );
        //     $this->Configurations->storeCustomerSetting($data);
        // } else {
        //     $data = array(
        //         'exists' => !empty($exists) ? 1 : 0,
        //         'customer_id' => $auth->CLIENTE_ID,
        //         'setting_type' => "setting_view",
        //         'setting_value' => 0,
        //     );
        //     $this->Configurations->storeCustomerSetting($data);
        // }

        // //Get Locations by user
        // $auth->locations = $this->db->query("SELECT l.LOCALIDAD_ID, l.NOMBRE_LOCALIDAD AS LOCALIDAD, l.FLETERA_ID,
        //     l.IMP_FLETE_LOCALIDAD, l.MIN_FLTE_PAGADO AS IMPTE_MINIMO_PED, l.PCTJ_FLETE_LOCALIDAD, l.TIPO_LOCALIDAD
        //     FROM _DIRS_CLIENTES dc INNER JOIN _LOCALIDADES l ON dc.LOCALIDAD_ID = l.LOCALIDAD_ID WHERE dc.CLIENTE_ID= {$auth->CLIENTE_ID}")->result();

        // //get initial discount
        // $discount =  $this->discounts->getDesctoArtCli($auth->CLIENTE_ID, 102453917, date('Y-m-d'), $auth->policy_artcli_id);

        // $auth->discount = isset($discount[0]['out_descto_cli']) ? floatval($discount[0]['out_descto_cli']) : 0;
        // $auth->initial_discount = floatval($auth->discount);

        // // para usar este metodo habilita el helper jwt y comentar el CreatorJWT en el header
        // // $jwt = new JWT();
        // // $jwtSecretKey = "appB3rny2021";
        // // $token = $jwt->encode($encrypt, $jwtSecretKey, "HS256");

        

        // $this->response(array(
        //     'status' => true,
        //     'message' => 'Customer retrieved sucessfully!',
        //     'data' => $auth
        // ), \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
