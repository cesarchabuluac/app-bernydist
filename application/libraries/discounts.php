<?php (defined('BASEPATH')) or exit('No direct script access allowed');
class Discounts
{
	private $CI;
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->database('intranet');
		$this->CI->load->library('session');
	}

	/**
     * Obtener el descuento del articulo
     * @param {*} in_cliente_id
     * @param {*} in_articulo_id
     * @param {*} in_fecha
     * @param {*} in_politica_precio_art_cli_id
     */
    public function getDesctoArtCli($customer_id, $product_id, $date, $in_politica_precio_art_cli_id)
    {
        $sp    = "CALL getDesctoArtCli(?, ?, ?, ?, 1, @test)";
        $params = array($customer_id, $product_id, date('Y-m-d', strtotime($date)), $in_politica_precio_art_cli_id);
        $data   = array();        
        $query  = $this->CI->db->query($sp, $params);
        $this->Logs('Query getDesctoArtCli : ' . $this->CI->db->last_query());
        if ($query) {
            $data = $query->result_array();
            $query->free_result();
            $query->next_result();
        }
        return $data;
    }

	public function generate($clave_cliente, $codigo_articulo)
	{
		$cliente	           = $this->CI->db->where('CLAVE_CLIENTE', $clave_cliente)->get('_CLIENTES')->row();
		$articulo 	           = $this->_getArticulo($codigo_articulo);
		//echo '{"request":{"status":"failed","reason":"EL id del producto en la fucnion generate de DISCOUNTS '.$articulo->id.'"}}';
		//Buscar políticas de descuentos
		$this->_getPoliticasDescuentos($cliente, $articulo);
		$this->_getDescuentosDePoliticas($cliente, $articulo);
		$this->_getPoliticasPromociones($cliente, $articulo);
		$this->_getDescuentosDePromociones($cliente, $articulo);
		$promociones           = $this->_sumatoria($cliente, $articulo);
		$return['promociones'] = $promociones;
		$return['descuento']   = $cliente->descuento;
		$return['descuentoweb'] = $this->DescuentoWebArticuloxPro2($cliente->CLIENTE_ID, $codigo_articulo);

		return $return;
	}
	public function IMPUESTO($CODE)
	{
		$product0 = $this->CI->db->query("select iva from products  where product_code='" . $CODE . "'");
		$product  = $product0->row();
		if ($product) {
			return $product->iva;
		} else {
			return -1;
		}
	}
	public function finalPrice($user, $product, $promocion, $key = 0)
	{
		$p = $product->price - ($product->price * $promocion / 100);
		$p = $p - $p * $user->PCTJ_PRONTOPAGO / 100; //pronto pago 
		$p = $this->DescuentoWeb_Calcula($user->CLIENTE_ID, $product->product_code, $p);
		$p = $p + $p * $this->IMPUESTO($product->product_code) / 100; // + iva
		return $p;
	}
	public function finalPrice2($user, $product, $promocion, $key = 0)
	{
		$p = $product['price'] - ($product['price'] * $promocion / 100);
		$p = $p - $p * $user->PCTJ_PRONTOPAGO / 100; //pronto pago 
		$p = $p + $p * $this->IMPUESTO($product->product_code) / 100; // + iva
		return $p;
	}
	public function DescuentoWeb($cliente_id, $clave_articulo, $cantidad, $precio_final)
	{
		$product0   = $this->CI->db->query("SELECT * FROM products
        INNER JOIN BR_PROMOCIONES_WEB ON products.id = BR_PROMOCIONES_WEB.articulo_id
        WHERE cliente_id = '" . $cliente_id . "' AND products.product_code ='" . $clave_articulo .
			"' and  (curdate() between BR_PROMOCIONES_WEB.FECHA_INI and BR_PROMOCIONES_WEB.FECHA_VIGENCIA)");
		$product    = $product0->row();
		$CANTIDAD   = 0;
		$PORCENTAJE = 0;
		if ($product) {
			foreach ($product0->result() as $fila) {
				$CANTIDAD      = $fila->CANTIDAD;
				$PORCENTAJE    = $fila->PCTJ_PROMOCION;
			}
			$calculando_desc = $precio_final * ($PORCENTAJE / 100);
			$precio_final    = $precio_final - $calculando_desc;
		}
		return  $precio_final;
	}
	public function DescuentoWeb_Calcula($cliente_id, $clave_articulo, $precio_final, $descGlobal = 0)
	{
		$product    = $this->CI->db->query("SELECT * FROM products
					   INNER JOIN BR_PROMOCIONES_WEB ON products.id = BR_PROMOCIONES_WEB.articulo_id
					   WHERE cliente_id = '{$cliente_id}' AND 
					   products.product_code ='{$clave_articulo}'  AND (curdate() BETWEEN BR_PROMOCIONES_WEB.FECHA_INI AND BR_PROMOCIONES_WEB.FECHA_VIGENCIA)")->row();

		if (!empty($product)) {
			$descGlobal = ($descGlobal > 0) ? $descGlobal :  $product->PCTJ_PROMOCION;
			$calculando_desc = $precio_final * ($descGlobal / 100);
			return ($precio_final - $calculando_desc);
		} else {
			return $precio_final;
		}
	}
	public function DescuentoWebArticulo($cliente_id, $clave_articulo)
	{
		$SQL        = "SELECT *
					  FROM products
					  INNER JOIN BR_PROMOCIONES_WEB ON products.id = BR_PROMOCIONES_WEB.articulo_id
					  WHERE  cliente_id='" . $cliente_id . "' and products.product_code='" . $clave_articulo .
			"' and (curdate() between BR_PROMOCIONES_WEB.FECHA_INI and BR_PROMOCIONES_WEB.FECHA_VIGENCIA)";
		$product0   = $this->CI->db->query($SQL);
		$product    = $product0->row();
		$CANTIDAD   = 0;
		if ($product) {
			foreach ($product0->result() as $fila) {
				$CANTIDAD   = 1;
			}
		}
		return  $CANTIDAD;
	}
	public function DescuentoWebArticuloxPro($cliente_id, $clave_articulo)
	{
		$SQL              = "SELECT BR_PROMOCIONES_WEB.PCTJ_PROMOCION
							FROM products
							INNER JOIN BR_PROMOCIONES_WEB ON products.id = BR_PROMOCIONES_WEB.articulo_id
							WHERE  cliente_id='" . $cliente_id . "' and products.product_code='" . $clave_articulo .
			"' and (curdate() between BR_PROMOCIONES_WEB.FECHA_INI and BR_PROMOCIONES_WEB.FECHA_VIGENCIA)";
		$product0         = $this->CI->db->query($SQL);
		$product          = $product0->row();
		$PCTJ_PROMOCION   = 0;
		if ($product) {
			foreach ($product0->result() as $fila) {
				$PCTJ_PROMOCION = $fila->PCTJ_PROMOCION;
			}
		}
		return  $PCTJ_PROMOCION;
	}
	public function DescuentoWebArticuloxPro2($cliente_id, $clave_articulo)
	{
		$product          = $this->CI->db->query("SELECT BR_PROMOCIONES_WEB.PCTJ_PROMOCION FROM products
			INNER JOIN BR_PROMOCIONES_WEB ON products.id = BR_PROMOCIONES_WEB.articulo_id
			WHERE cliente_id='{$cliente_id}' AND products.product_code='{$clave_articulo}' AND 
			(curdate() BETWEEN BR_PROMOCIONES_WEB.FECHA_INI AND BR_PROMOCIONES_WEB.FECHA_VIGENCIA)")->row();
		if (!empty($product)) {
			return $product->PCTJ_PROMOCION;
		} else {
			return 0;
		}
	}

	public function priceTable($product, $user)
	{
		if (isset($product->discounts['promociones'][1])) {
			$final    = $product->price - $product->price * $product->discounts['promociones'][1] / 100;
			$final    = $final - $final * $user->PCTJ_PRONTOPAGO / 100;
			$final    = $this->DescuentoWeb_Calcula($user->CLIENTE_ID, $product->product_code, $final);
			$final    = $final + $final * $this->IMPUESTO($product->product_code) / 100;
			return $final;
		} else {
			$discount = isset($product->discounts['descuento']) ? $product->discounts['descuento'] : 0;
			$con_desc = $product->price - $product->price * $discount / 100;
			$final    = $con_desc - $con_desc * $user->PCTJ_PRONTOPAGO / 100;
			$final    = $this->DescuentoWeb_Calcula($user->CLIENTE_ID, $product->product_code, $final);
			$final    = $final + $final * $this->IMPUESTO($product->product_code) / 100;

			// echo $final . "<br>";			
			// $flete = isset($product->PCTJ_FLETE) ? ($product->PCTJ_FLETE / 100) : 0;
			// $final = $final + ($final * $flete);
			// echo $final . "<br>";
			return $final;
		}
	}

	public function _sumatoria(&$cliente, &$articulo)
	{
		$promociones = array();

		foreach ($cliente->politicasPromociones as $key => $politica) {
			$acum = TRUE;
			foreach ($politica->promociones as $key2 => $promocion) {
				$this->_revisar($promociones, $promocion, $acum);
				$acum = FALSE;
			}
		}

		$descWeb = $this->DescuentoWebArticuloxPro2($cliente->CLIENTE_ID, $articulo->product_code);
		if (!empty($promociones)) {
			foreach ($promociones as &$d) {
				$d += (((100 - $d) * $cliente->descuento / 100) + $descWeb);
			}
		}

		return $promociones;
	}
	private function _revisar(&$discounts, $promocion, $acum)
	{
		$aplica_index = array();
		foreach ($discounts as $index => $item) {
			if ($promocion->VOLUMEN <= $index) {
				$aplica_index[] = $index;
			}
		}
		// si no tengo el volumen en mi cadena de volumentes, se agrega
		if (!array_key_exists($promocion->VOLUMEN, $discounts)) {
			$discounts[$promocion->VOLUMEN] = $promocion->PORCENTAJE;
		}
		if ($acum) {
			foreach ($aplica_index as $index => $value) {
				if (array_key_exists($value, $discounts)) {
					$discounts[$value] +=  (100 - $discounts[$value]) * $promocion->PORCENTAJE / 100;
				}
			}
		}
	}
	public function _getArticulo($codigo_articulo = 0)
	{
		$articulo = $this->CI->db->where('product_code', $codigo_articulo)->get('products');
		if ($articulo->num_rows() == 0) {
			return NULL;
		} else {
			$articulo 				= $articulo->row();
			$articulo->marca 		= $this->CI->db->where('id', $articulo->brand_id)->get('brands')->row();
			$articulo->linea 		= $this->CI->db->where('LINEA_ARTICULO_ID', $articulo->linea_articulo_id)->get('_LINEAS_ARTICULOS')->row();
			$articulo->grupo_linea 	= $this->CI->db->where('GRUPO_LINEA_ID', $articulo->linea->GRUPO_LINEA_ID)->get('_GRUPOS_LINEAS')->row();
			return $articulo;
		}
	}
	private function _getPoliticasDescuentos(&$cliente, &$articulo)
	{
		$politica_cliente 	= $this->CI->db->where('CLIENTE_ID', $cliente->CLIENTE_ID)->get('_POLITICA_PRECLI_CLI');
		if ($politica_cliente->num_rows() == 0) {
			$cliente->ZONA_CLIENTE_ID = !empty($cliente->ZONA_CLIENTE_ID) ? $cliente->ZONA_CLIENTE_ID : 0;
			$politica_cliente_por_zona = $this->CI->db->where('ZONA_CLIENTE_ID', $cliente->ZONA_CLIENTE_ID)->get('_POLITICA_PRECLI_ZONA');
			if ($politica_cliente_por_zona->num_rows() > 0) {
				$politica_cliente_por_zona = $politica_cliente_por_zona->row();
				$cliente->POLITICA_PRECIO_ART_CLI_ID =  $politica_cliente_por_zona;
			} else {
				$cliente->POLITICA_PRECIO_ART_CLI_ID = null;
			}
		} else {
			$politica_cliente = $politica_cliente->row();
			$cliente->POLITICA_PRECIO_ART_CLI_ID =  $politica_cliente;
		}

		if ($cliente->POLITICA_PRECIO_ART_CLI_ID != NULL) {
			$cliente->POLITICA_PRECIO_ART_CLI_ID = $this->CI->db->where('POLITICA_PRECIO_ART_CLI_ID', $cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID)->get('_POLITICAS_PRECIOS_ART_CLI')->row();
		}
	}

	private function _getDescuentosDePoliticas(&$cliente, &$articulo)
	{
		//echo '"EL id del producto en la fucnion _getDescuentosDePoliticas '.$articulo->id;
		if (empty($cliente->POLITICA_PRECIO_ART_CLI_ID)) {
			$cliente->POLITICA_PRECIO_ART_CLI_ID = (object)array("POLITICA_PRECIO_ART_CLI_ID" => 0);
		}
		$articulo->descuentos['articulo'] 	= $this->descuento_articulo($cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID, $articulo->id);
		if ($articulo->descuentos['articulo'] == NULL) {
			$articulo->descuentos['marca'] = $this->descuento_marca($cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID, $articulo->brand_id);
			if ($articulo->descuentos['marca'] == NULL) {
				$articulo->descuentos['linea'] = $this->descuento_linea($cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID, $articulo->linea_articulo_id);
				if ($articulo->descuentos['linea'] == NULL) {
					$articulo->descuentos['grupo_linea'] 	= $this->descuento_grupoLinea($cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID, $articulo->linea_articulo_id);
					if ($articulo->descuentos['grupo_linea'] != NULL) {
						$cliente->descuento = $articulo->descuentos['grupo_linea']->DESCUENTO;
					}
				} else {
					$cliente->descuento = $articulo->descuentos['linea']->DESCUENTO;
				}
			} else {
				$cliente->descuento = $articulo->descuentos['marca']->DESCUENTO;
			}
		} else {
			$cliente->descuento = $articulo->descuentos['articulo']->DESCUENTO;
		}
		if (!property_exists($cliente, "descuento")) {
			$cliente->descuento = 0;
		}
		$articulo->precioConDescuento = $articulo->price - ($articulo->price * $cliente->descuento / 100);
		//quitar prontopago;
		$articulo->precioConDescuento = $articulo->precioConDescuento - ($articulo->precioConDescuento * $cliente->PCTJ_PRONTOPAGO / 100);
	}

	private function descuento_articulo($POLITICA_PRECIO_ART_CLI_ID, $articulo_id)
	{
		$descuento = $this->CI->db->where('POLITICA_PRECIO_ART_CLI_ID', $POLITICA_PRECIO_ART_CLI_ID)->where('ARTICULO_ID', $articulo_id)->get('_POLITICA_PRECLI_ART');
		if ($descuento->num_rows() == 0) {
			return NULL;
		} else {
			$descuento = $descuento->row();
			return $descuento;
		}
	}
	private function descuento_marca($POLITICA_PRECIO_ART_CLI_ID, $marca_id)
	{
		$descuento = $this->CI->db->where('POLITICA_PRECIO_ART_CLI_ID', $POLITICA_PRECIO_ART_CLI_ID)->where('MARCA_ART_ID', $marca_id)->get('_POLITICA_PRECLI_MARCA');
		if ($descuento->num_rows() == 0) {
			return NULL;
		} else {
			$descuento = $descuento->row();
			return $descuento;
		}
	}
	private function descuento_linea($POLITICA_PRECIO_ART_CLI_ID, $linea_id)
	{
		$descuento = $this->CI->db->where('POLITICA_PRECIO_ART_CLI_ID', $POLITICA_PRECIO_ART_CLI_ID)->where('LINEA_ARTICULO_ID', $linea_id)->get('_POLITICA_PRECLI_LINEA');
		if ($descuento->num_rows() == 0) {
			return NULL;
		} else {
			$descuento = $descuento->row();
			return $descuento;
		}
	}
	private function descuento_grupoLinea($POLITICA_PRECIO_ART_CLI_ID, $linea_id)
	{
		$linea 		= $this->CI->db->where('LINEA_ARTICULO_ID', $linea_id)->get('_LINEAS_ARTICULOS')->row();
		$descuento = $this->CI->db->where('POLITICA_PRECIO_ART_CLI_ID', $POLITICA_PRECIO_ART_CLI_ID)->where('GRUPO_LINEA_ID', @$linea->GRUPO_LINEA_ID)->get('_POLITICA_PRECLI_GRUPO');
		if ($descuento->num_rows() == 0) {
			return NULL;
		} else {
			$descuento = $descuento->row();
			return $descuento;
		}
	}

	/*PROMOCIONES*/
	private function  _getPoliticasPromociones(&$cliente, &$articulo)
	{
		// politicas por el cliente
		$politicas = $this->CI->db->where('CLIENTE_ID', $cliente->CLIENTE_ID)->get('_POL_DES_CLIE');
		$pols = array();
		foreach ($politicas->result() as $politica) {
			$pols[] = $politica;
		}



		// politicas por la zona del cliente
		$politicas_zona = $this->CI->db->where('ZONA_CLIENTE_ID', $cliente->ZONA_CLIENTE_ID)->get('_POL_DES_ZONA');
		foreach ($politicas_zona->result() as $politica) {
			$pols[] = $politica;
		}
		//politicas por el descuento del cliente
		$politicas_zona = $this->CI->db->where('POLITICA_PRECIOS_ART_CLI_ID', $cliente->POLITICA_PRECIO_ART_CLI_ID->POLITICA_PRECIO_ART_CLI_ID)->get('_POL_DES_PREARTCLI');
		foreach ($politicas_zona->result() as $politica) {
			$pols[] = $politica;
		}
		$politicasHabilitadas = array();
		foreach ($pols as $politica) {
			$this->CI->db->where('POL_DSCTO_ARTCLIVOL_ID', $politica->POL_DSCTOS_ARTCLIVOL_ID);
			$this->CI->db->where('HABILITADA', 'S');
			$this->CI->db->where('(ES_PERMANENTE="S" or ("' . date('Y-m-d') . '">=FECHA_INI_VIGENCIA  and "' . date('Y-m-d') . '"<= FECHA_FIN_VIGENCIA))', NULL, FALSE);
			$found = $this->CI->db->get('_POLITICAS_DSCTOS_ARTCLIVOL');
			if ($found->num_rows() == 1) {
				$politicasHabilitadas[] = $found->row();
			}
		}
		$cliente->politicasPromociones = $politicasHabilitadas;
	}

	private function _getDescuentosDePromociones(&$cliente, &$articulo)
	{
		foreach ($cliente->politicasPromociones as $politicaPromocion) {

			$this->promociones_articulos($politicaPromocion, $articulo);
			$this->promociones_linea($politicaPromocion, $articulo);
		}
	}
	private function promociones_articulos(&$politica, &$articulo)
	{
		$politica->promociones = array();
		$promociones = $this->CI->db->order_by('VOLUMEN', 'DESC')->where('POL_DSCTOS_ARTCLIVOL_ID', $politica->POL_DSCTO_ARTCLIVOL_ID)->where('ARTICULO_ID', $articulo->id)->get('_POL_DES_ARTICULO');
		if ($promociones->num_rows() > 0) {
			foreach ($promociones->result() as $promocion) {
				array_push($politica->promociones, $promocion);
			}
		}
	}

	private function promociones_linea(&$politica, &$articulo)
	{
		$promociones = $this->CI->db->order_by('VOLUMEN', 'DESC')->where('POL_DSCTOS_ARTCLIVOL_ID', $politica->POL_DSCTO_ARTCLIVOL_ID)->where('LINEA_ARTICULO_ID', $articulo->linea_articulo_id)->get('_POL_DES_LINEA');
		if ($promociones->num_rows() > 0) {
			foreach ($promociones->result() as $promocion) {
				array_push($politica->promociones, $promocion);
			}
		}
	}

	private function promociones_grupoLinea(&$politica, &$articulo)
	{
		$promociones = $this->CI->db->order_by('VOLUMEN', 'DESC')->where('POL_DSCTOS_ARTCLIVOL_ID', $politica->POLITICA_PRECIO_ART_CLI_ID)->where('GRUPO_LINEA_ID', $articulo->id)->get('_POL_DES_GRUPOLINEA');
		if ($promociones->num_rows() > 0) {
			foreach ($promociones->result() as $promocion) {
				array_push($politica->promociones, $promocion);
			}
		}
	}

	/********* FIN DESCUENTOS   ***************/

	public function Logs($Linea)
	{
		$file = fopen("descuentos.txt", "a");
		fwrite($file, date('Y-m-d H:i:s') . " => " . $Linea . PHP_EOL);
		fclose($file);
	}
}
