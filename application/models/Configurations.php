<?php

class Configurations extends CI_Model
{
	public function getStripeCustomer($customerID)
	{
		$data = $this->db->where('cliente_id', $customerID)->get('_clientes_ad')->row();
		return !empty($data) ? null : $data->stripe_customer;
	}

	public function getConektaKeys()
	{
		return $this->db->query("SELECT ck.key_publica,ck.key_privada,ck.config_empresa_id,ck.type,ck.proveedor FROM conekta_keys ck WHERE ck.activa='S'")->result();
	}

	//Determine which company runs the web service
	public function getCompanyConfig()
	{
		$data = $this->db->query("SELECT `value` FROM config WHERE `key`='pEmpresa'")->row();
		return !empty($data) ? $data->value : 2; //2 is TEST
	}

	/**
	 * @param {*} customer_id
	 */
	public function getPolDesctoArtCli($customer_id)
	{
		$sp    = "CALL getPolDesctoArtCli_id(?, @test)";
		$params = array($customer_id,);
		$data   = array();
		$query  = $this->db->query($sp, $params);
		if ($query) {
			$data = $query->result_array();
			$query->free_result();
			$query->next_result();
		}
		return $data[0]['out_politica_precio_art_cli_id'];
	}

	/**
	 * @param {*} customer_id
	 */
	public function getPolDesctoArtCliVol($customer_id)
	{
		$current_date = date('Y-m-d');
		$sp    = "CALL getPolDesctoArtCliVol_id(?, ?, @test1, @test2)";
		$params = array($customer_id, $current_date);
		$data   = array();
		$query  = $this->db->query($sp, $params);
		if ($query) {
			$data = $query->result_array();
			$query->free_result();
			$query->next_result();
		}
		return $data[0]['out_pol_dscto_artclivol_id'];
	}

	/**
	 * Get customer type
	 */
	public function getCustomerType($customer_id)
	{
		return $this->db->query("SELECT CASE WHEN CONTADO='S' THEN 'GENERAL' ELSE (CASE WHEN (CONTADO='N' AND SOLO_VTA_CONTADO='S') THEN 'DISTRIBUIDOR' ELSE
					'CREDITO' END) END AS `type` FROM  _CLIENTES WHERE CLIENTE_ID={$customer_id}")->row();
	}

	/**
	 * Get discount range by customer type
	 */
	public function getDiscountRange($customerType)
	{
		return  $this->db->query("SELECT 
		(SELECT initial_percentage FROM discount_range WHERE `type` = '{$customerType}' ORDER BY initial_percentage LIMIT 1) as 'initial_percentage',
		(SELECT final_percentage FROM discount_range where `type` = '{$customerType}' ORDER BY final_percentage DESC LIMIT 1) as 'final_percentage'")->row();
	}

	/**
	 * Get customer emails
	 */
	public function getCustomerEmails($customer_id)
	{
		return $this->db->query("SELECT dc.*, c.NOMBRE AS ciudad, e.NOMBRE AS estado, p.NOMBRE AS pais, l.NOMBRE_LOCALIDAD AS localidad 
		FROM `_DIRS_CLIENTES` dc 
		LEFT JOIN `_CIUDADES` c ON dc.CIUDAD_ID = c.CIUDAD_ID 
		LEFT JOIN `_ESTADOS` e ON dc.ESTADO_ID = e.ESTADO_ID 
		LEFT JOIN `_PAISES` p ON dc.PAIS_ID = p.PAIS_ID 
		LEFT JOIN `_LOCALIDADES` l ON dc.LOCALIDAD_ID = l.LOCALIDAD_ID 
		WHERE dc.CLIENTE_ID = {$customer_id} AND ES_DIR_PPAL='S'")->row();
	}

	/**
	 * 
	 */
	public function getCustomerSetting($customer_id, $type)
	{
		$this->db->from('customer_settings');
		$this->db->where('customer_id', $customer_id);
		$this->db->where('setting_type', $type);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->row() : [];
	}

	/***
	 * 
	 */
	public function storeCustomerSetting($data)
	{
		if ($data['exists'] == 1) {
			unset($data['exists']);
			$data['updated_at'] = date('Y-m-d H:i:s:');
			$this->db->update('customer_settings', $data);
		} else {
			unset($data['exists']);
			$data['created_at'] = date('Y-m-d H:i:s:');
			$data['updated_at'] = date('Y-m-d H:i:s:');
			$this->db->insert('customer_settings', $data);
		}
	}
}
