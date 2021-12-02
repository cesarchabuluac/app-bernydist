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
class Product extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['product_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['product_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['product_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function product_get()
    {
        $products = $this->db->query("SELECT * FROM products LIMIT 100")->result();
        $this->response($products, \Restserver\Libraries\REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }


    public function lines_get()
    {
        $parameters = json_decode(file_get_contents('php://input'), true);

        $lines = $this->mcatalogo->linesFiltered(
            @$parameters["busqueda"],
            @$parameters["divisions"],
            @$parameters["categories"],
            @$parameters["groups"],
            @$parameters["brands"]
        );

        foreach ($lines as $line) {
            $uriArray = array();
            $uriArray["tienda"] = "0";
            $uriArray["giro"] = create_slug($line->name . " " . $line->id);
            $uriStr = $this->uri->assoc_to_uri($uriArray);
            $line->image = URL_IMAGE . '/online-store/' . $line->name . '.jpeg';
            $line->filter_url = $uriStr;
        }

        $this->response($lines, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }


    public function categories_get()
    {

        // $parameters = json_decode(file_get_contents('php://input'), true);
        $parameters = [];
        $categories = $this->mcatalogo->get_categories_by_division(
            5,
            0,
            @$parameters["busqueda"],
            @$parameters["divisions"],
            @$parameters["categories"],
            @$parameters["brands"],
            @$parameters["groups"],
            @$parameters["lines"],
            @$parameters["userId"],
            @$parameters["newest"],
            @$parameters["orden"],
            @$parameters["relevant"],
            true
        );

        foreach ($categories as $tmpCategory) {
            $uriArray = $this->uri->uri_to_assoc(1);
            $uriArray["tienda"] = "categoria";

            $uriStr = $this->uri->assoc_to_uri($uriArray);

            $url_title = url_title($tmpCategory->category_name, 'underscore', TRUE);
            $tmpCategory->url_title = $uriStr . $tmpCategory->category_id . "_" . $url_title;
            $tmpCategory->image = URL_IMAGE  . "/categoriesweb/" . $tmpCategory->category_id . ".png";

            //Products
            $tmpCategory->product = $this->mcatalogo->get_products($tmpCategory->category_id);
            if (isset($this->data['user']->CLAVE_CLIENTE) && $this->data['user']->is_public == 0) {
                $discount = $this->discounts->getDesctoArtCli($this->data['user']->CLIENTE_ID, $tmpCategory->product[0]->id, date('Y-m-d'), $this->data['user']->policy_artcli_id);
                $tmpCategory->product[0]->discounts = $this->discounts->generate($this->data['user']->CLAVE_CLIENTE,  $tmpCategory->product[0]->product_code);
                $tmpCategory->product[0]->discounts['descuento'] = $discount[0]['out_descto_cli'];
                $tmpCategory->total_with_discount = $this->discounts->priceTable($tmpCategory->product[0], $this->data['user']);
            }
        }

        $this->response($categories, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    public function relevants_get()
    {

        $parameters = json_decode(file_get_contents('php://input'), true);
        $parameters['relevant'] = true;
        $relevants = $this->mcatalogo->get_categories_by_division(
            5,
            0,
            @$parameters["busqueda"],
            @$parameters["divisions"],
            @$parameters["categories"],
            @$parameters["brands"],
            @$parameters["groups"],
            @$parameters["lines"],
            @$parameters["userId"],
            @$parameters["newest"],
            @$parameters["orden"],
            @$parameters["relevant"],
            true
        );

        foreach ($relevants as $tmpCategory) {
            $uriArray = $this->uri->uri_to_assoc(1);
            $uriArray["tienda"] = "categoria";

            $uriStr = $this->uri->assoc_to_uri($uriArray);

            $url_title = url_title($tmpCategory->category_name, 'underscore', TRUE);
            $tmpCategory->url_title = $uriStr . $tmpCategory->category_id . "_" . $url_title;
            $tmpCategory->image = URL_IMAGE  . "/categoriesweb/" . $tmpCategory->category_id . ".png";

            //Products
            $tmpCategory->product = $this->mcatalogo->get_products($tmpCategory->category_id);
            if (isset($this->data['user']->CLAVE_CLIENTE) && $this->data['user']->is_public == 0) {
                $discount = $this->discounts->getDesctoArtCli($this->data['user']->CLIENTE_ID, $tmpCategory->product[0]->id, date('Y-m-d'), $this->data['user']->policy_artcli_id);
                $tmpCategory->product[0]->discounts = $this->discounts->generate($this->data['user']->CLAVE_CLIENTE,  $tmpCategory->product[0]->product_code);
                $tmpCategory->product[0]->discounts['descuento'] = $discount[0]['out_descto_cli'];
                $tmpCategory->total_with_discount = $this->discounts->priceTable($tmpCategory->product[0], $this->data['user']);
            }
        }

        $this->response($relevants, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    public function groups_get()
    {
        $parameters = json_decode(file_get_contents('php://input'), true);

        $groups = $this->mcatalogo->groupsFiltered(
            @$parameters["busqueda"],
            @$parameters["divisions"],
            @$parameters["categories"],
            @$parameters["lines"],
            @$parameters["brands"]
        );

        foreach ($groups as $group) {
            $uriArray = array();

            $uriArray["tienda"] = "0";
            $uriArray["grupo"] = create_slug($group->name . " " . $group->id);
            $uriStr = $this->uri->assoc_to_uri($uriArray);
            $group->filter_url = $uriStr;
            $group->image = str_replace('uploads', '', URL_IMAGE) . $group->image;
        }

        $this->response($groups, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    public function brands_get()
    {
        $brands = $this->mcatalogo->brands();
        foreach ($brands as $brand) {
            $uriArray = array();
            $uriArray["tienda"] = "0";
            $uriArray["marca"] = $brand->id;
            $uriStr = $this->uri->assoc_to_uri($uriArray);
            $brand->filter_url = $uriStr;
            $brand->image = URL_IMAGE . '/marcas/' . $brand->id . '.jpg';
        }

        $this->response($brands, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
