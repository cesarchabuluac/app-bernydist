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
class Customer extends \Restserver\Libraries\REST_Controller
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

    
    public function store_post()
    {

        $parameters = json_decode(file_get_contents('php://input'), true);

        $email         = $parameters['email'];
        $password     = $parameters['password'];
        $name         = sanear_string($parameters['name']);
        $latitude   = $parameters['latitude'];
        $longitude  = $parameters['longitude'];
        $ubication   = (!empty($latitude) && !empty($longitude))  ? "{$latitude}, {$longitude}" : "0,0";
        $isCounter  = 198336;
        $state     = strtoupper(sanear_string($parameters["state"]));
        $phone     = $parameters["phone"];
        $postal_code = $parameters["postal_code"];
        $municipality = strtoupper(sanear_string($parameters["municipality"]));
        $location_id = intval($parameters["location_id"]);
        $isNewLocation = boolval($parameters["is_new_location"]);
        $new_location   = !empty($parameters["new_location"]) ? strtoupper($parameters["new_location"]) : null;
        $dirCliId = 0;
        $email_verified = boolval($parameters["email_verified"]);

        $state_id = null;
        $city_id = null;


        //Valid required fields
        if (empty($name) || empty($password) || empty($state) || empty($phone) || empty($postal_code)) {
            $this->response(array(
                'status' => false,
                'message' => 'Debe llenar los campos obligatorios!',
                'data' => array(
                    "customer_counter" => false,
                    "email" => $email,
                    "dir_cli_id" => $dirCliId
                )
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        }

        //Valid if the customer exists in _br_emails_clientes		
        $emailData = $this->db->query("SELECT * FROM _BR_EMAILS_CLIENTES WHERE EMAIL='{$email}'")->row();
        if (!empty($emailData)) {
            $dirCliId = $emailData->DIR_CLI_ID;
            $emailData->customer_counter = ($isCounter == $emailData->CLIENTE_ID) ?? false;
            $this->response(array(
                'status' => false,
                'message' => 'Actualmente el cliente ya esta registrado con el correo ingresado!',
                'data' => $emailData
            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {

            $this->db->trans_begin();

            try {

                //Find state by name
                $stateData = $this->db->query("SELECT ESTADO_ID FROM _ESTADOS WHERE NOMBRE = '{$state}'")->row();

                //Find city by state_id and city name
                $cityData = $this->db->query("SELECT CIUDAD_ID FROM _CIUDADES WHERE ESTADO_ID = {$stateData->ESTADO_ID} AND NOMBRE = '{$municipality}' LIMIT 1")->row();

                if (empty($cityData)) {

                    //There is no city therefore call the server api 192.168.2.3
                    $payload = array(
                        "city_name" => $municipality,
                        "state_id" => $stateData->ESTADO_ID
                    );
                    $service = callApi('wscustomer/cities_post', $payload);
                    if (empty($service)) {
                        $this->db->trans_rollback();
                        $this->response(array(
                            'status' => false,
                            'message' => 'No se pudo registar ciudad, intente nuevamente!',
                            "data" => $service->data
                        ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                    } else {
                        $city_id = $service->data->CIUDAD_ID;
                    }
                } else {
                    $city_id = $cityData->CIUDAD_ID;
                }

                //Check is new location
                if ($isNewLocation) {

                    //Call endpoint store location
                    $payload = array(
                        "location_name" => $new_location,
                        "city_id" => $city_id

                    );

                    if (empty($new_location)) {
                        $this->db->trans_rollback();
                        $this->response(array(
                            'status' => false,
                            'message' => 'No se pudo registar la localidad, intente nuevamente!',
                            "data" => $new_location
                        ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                    }

                    $service = callApi("wscustomer/location_post", $payload);

                    if (empty($service) && !$service->status) {

                        $this->db->trans_rollback();
                        $this->response(array(
                            'status' => false,
                            'message' => 'No se pudo registar la localidad, intente nuevamente!',
                            "data" => $service->data
                        ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                    } else {
                        $location_id = $service->data->LOCALIDAD_ID;
                    }
                }

                //Get next folios
                $nextFolio = $this->db->query("SELECT * FROM folios f WHERE f.tabla  = '_CLIENTES'")->row();

                $customer['CLIENTE_ID'] = nextFolio();
                $customer['CLAVE_CLIENTE'] = $nextFolio->serie . str_pad(intval($nextFolio->value + 1), 6, "0", STR_PAD_LEFT);
                $customer['NOMBRE'] = $name;
                $customer['ESTATUS'] = "I"; //Inactivo
                $customer['LIMITE_CREDITO'] = 1;
                $customer['SERIE'] = "M";
                $customer['IMPUESTO'] = 16;
                $customer['DOCTOS_MAX'] = 1;
                $customer['CONTADO'] = "S";
                $customer['PCTJ_PRONTOPAGO'] = 0;
                $customer['IMPORTE_MIN_PED_FLETE'] = 300; //Se asignad el importe minimo
                $customer['DIAS_VENCIMIENTO_PP'] = 0;
                $customer['PASS'] = $password;
                $customer['PEDIDO_WEB_BLOQ'] = "N"; ////					
                $customer['COND_PAGO_WEB_ID'] = 88635; ///
                $customer['IMPTE_MINIMO_PED_BLOQ'] = 1; ////
                $customer['DIAS_EXTRA'] = 0;
                $customer['COMISION_PAGO_WEB'] = 0;
                $customer['SOLO_VTA_CONTADO'] = 'S';
                $customer['IMPTE_MINIMO_PED'] = 300;
                if ($this->db->insert('_CLIENTES', $customer)) {
                    $dir_cli['DIR_CLI_ID'] = $customer['CLIENTE_ID'];
                    $dir_cli['CLIENTE_ID'] = $customer['CLIENTE_ID'];
                    $dir_cli['NOMBRE_CONSIG'] = "Dirección Principal"; //$name;
                    $dir_cli['PAIS_ID'] = 166;
                    $dir_cli['ES_DIR_PPAL'] = "S";
                    $dir_cli['CALLE'] = "-- PENDIENTE --";
                    $dir_cli['EMAIL'] = $email;
                    $dir_cli['PASS'] = $password;
                    $dir_cli['TIPO_DIR'] = "F";
                    $dir_cli['RFC_CURP'] = "XAXX010101000";
                    $dir_cli['UBICACION'] = $ubication;
                    $dir_cli['TELEFONO1'] = $phone;
                    $dir_cli['CIUDAD_ID'] = $city_id;
                    $dir_cli['ESTADO_ID'] = $stateData->ESTADO_ID;
                    $dir_cli['CODIGO_POSTAL'] = $postal_code;
                    $dir_cli['LOCALIDAD_ID'] = $location_id;
                    if ($this->db->insert('_DIRS_CLIENTES', $dir_cli)) {

                        $email_cli['EMAIL_ID'] = $customer['CLIENTE_ID'];
                        $email_cli['CLIENTE_ID'] = $customer['CLIENTE_ID'];
                        $email_cli['EMAIL'] = $email;
                        $email_cli['ENVIO_DOCTO_FISCAL'] = "S";
                        $email_cli['ENVIO_ORIGINAL'] = "S";
                        $email_cli['ENVIO_COPIA'] = "N";
                        $email_cli['DIR_CLI_ID'] = $dir_cli['DIR_CLI_ID'];
                        if (!$this->db->insert('_BR_EMAILS_CLIENTES', $email_cli)) {
                            $this->db->trans_rollback();
                            $this->response(array(
                                'status' => false,
                                'message' => 'No se pudo registar el correo del cliente, intente nuevamente!',
                                "data" => array()
                            ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                        }
                    } else {
                        $this->db->trans_rollback();
                        $this->response(array(
                            'status' => false,
                            'message' => 'No se pudo registar el cliente, intente nuevamente!',
                            "data" => array()
                        ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->db->trans_rollback();
                    $this->response(array(
                        'status' => false,
                        'message' => 'No se pudo registar el cliente, intente nuevamente!',
                        "data" => array()
                    ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                }

                //Update Folio
                $where = array(
                    'serie' => 'PBL',
                    'tabla' => '_CLIENTES'
                );
                $this->db->where($where);
                $update = $this->db->update('folios', ['value' => intval($nextFolio->value + 1)]);

                $this->db->where(array(
                    "serie" => 'NEXT',
                    "tabla" => 'GENERAL'
                ));

                $this->db->update("folios", ['value' =>  abs(nextFolio())]);

                if (!$update) {
                    $this->db->trans_rollback();
                    $this->response(array(
                        'status' => false,
                        'message' => 'No se pudo registar el folio consecutivo del cliente, intente nuevamente!',
                        "data" => array()
                    ), \Restserver\Libraries\REST_Controller::HTTP_OK);
                }

                //Data query location
                $locationData = $this->db->query("SELECT c.NOMBRE AS city, e.NOMBRE AS state, l.NOMBRE_LOCALIDAD AS location FROM `_DIRS_CLIENTES` dc
                    INNER JOIN `_ciudades` c ON dc.CIUDAD_ID = c.CIUDAD_ID 
                    INNER JOIN `_estados` e ON dc.ESTADO_ID  = e.ESTADO_ID 
                    INNER JOIN `_localidades` l ON dc.LOCALIDAD_ID  = l.LOCALIDAD_ID 
                    WHERE dc.CLIENTE_ID = {$customer['CLIENTE_ID']} LIMIT 1")->row();

                $data['email']         = $email;
                $data['password']     = $password;
                $data['name']         = $name;
                $data['city_name']         = $locationData->city;
                $data['state_name']        = $locationData->state;
                $data['location_name'] =  $locationData->location;
                $data['phone']        = $phone;
                $data['postal_code'] = $postal_code;
                $customer['CLAVE_CLIENTE'] = base64_encode($customer['CLAVE_CLIENTE']);
                $customer['CLIENTE_ID'] = base64_encode($customer['CLIENTE_ID']);
                $email = base64_encode($email);
                $data['link'] = base_url() . "pages/activate_account?hash={$customer['CLAVE_CLIENTE']}&e={$email}&i={$customer['CLIENTE_ID']}";
                $msg = $this->load->view('emails/register', $data, TRUE);
                $subject = "Berny - Registro de cliente";
                sendMail($data['email'], $subject, $msg, FALSE, (ENVIRONMENT === 'production') ? NOTIFICATION_EMAIL_ACTIVATED_ACCOUNT: null);

                //Successfully
                $this->db->trans_commit();

                $this->response(array(
                    'status' => true,
                    'message' => 'Cliente registrado correctamente, se ha enviado un correo para activar su cuenta!',
                    "data" => $customer
                ), \Restserver\Libraries\REST_Controller::HTTP_OK);
            } catch (Exception $ex) {
                // $this->Logs($ex, "Register");
                $this->db->trans_rollback();
                $this->response(array(
                    'status' => false,
                    'message' => 'No se pudo registar el cliente, intente nuevamente!',
                    "data" => $ex->errorInfo[2]
                ), \Restserver\Libraries\REST_Controller::HTTP_OK);
            }

            // //Find state by name
            // $stateData = $this->db->query("SELECT ESTADO_ID FROM _ESTADOS WHERE NOMBRE = '{$state}'")->row();
            // if (empty($stateData)) {
            //     $this->response(array(
            //         'status' => false,
            //         'message' => 'No se pudo localizar el estado, intente nuevamente!',
            //         'data' => array(
            //             "customer_counter" => false,
            //             "email" => $email,
            //             "dir_cli_id" => $dirCliId
            //         )
            //     ), \Restserver\Libraries\REST_Controller::HTTP_OK);
            // } else {

            //     $state_id = $stateData->ESTADO_ID;

            //     //Find city by name and state_id
            //     $cityData = $this->db->query("SELECT CIUDAD_ID FROM _CIUDADES WHERE ESTADO_ID = {$stateData->ESTADO_ID} AND NOMBRE = '{$municipality}' LIMIT 1")->row();
            //     if (empty($cityData)) {
            //         $this->response(array(
            //             'status' => false,
            //             'message' => 'No se pudo localizar la ciudad, intente nuevamente!',
            //             'data' => array(
            //                 "customer_counter" => false,
            //                 "email" => $email,
            //                 "dir_cli_id" => $dirCliId
            //             )
            //         ), \Restserver\Libraries\REST_Controller::HTTP_OK);
            //     } else {

            //         //There is no city therefore call the server api 192.168.2.3
            //         $payload = array(
            //             "city_name" => $municipality,
            //             "state_id" => $stateData->ESTADO_ID
            //         );
            //         $service = callApi('wscustomer/cities_post', $payload);

            //         if (!empty($service) && $service->status) {
            //             $city_id = $service->data->CIUDAD_ID;

            //             //Insert on cities
            //             $this->db->insert("_CIUDADES", $service->data);
            //         } else {
            //             $this->response(array(
            //                 'status' => false,
            //                 'message' => 'No se pudo localizar la ciudad, intente nuevamente!',
            //                 'data' => $service->data
            //             ), \Restserver\Libraries\REST_Controller::HTTP_OK);
            //         }
            //     }
            // }
        }
    }

    public function Logs($Linea, $FILE = "Register")
    {
        $file = fopen($FILE . ".txt", "a");
        fwrite($file, getDateTime() . '=>' .  $Linea . PHP_EOL);
        fclose($file);
    }
}
