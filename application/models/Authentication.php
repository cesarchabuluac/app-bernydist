<?php

class Authentication extends CI_Model
{
    public function check_auth($code, $password, $isByEmail) {

        //Password root 
        $root = $this->db->query("SELECT contrasena FROM _root WHERE contrasena='{$password}'")->row();

        $passwordCondition = " ";
		if ($root) {
			if ($password === $root->contrasena) {
				$passwordCondition = " ";
			} else {
				$passwordCondition = " AND dc.PASS='{$password}' ";
			}
		} else {
			$passwordCondition = " AND dc.PASS='{$password}' ";
		}

        $condition = ($isByEmail) ? " bec.EMAIL='{$code}' " : " c.CLAVE_CLIENTE='{$code}' ";

        $user = $this->db->query("SELECT c.CLIENTE_ID, c.CLAVE_CLIENTE, c.NOMBRE, c.CONTACTO1, c.CONTACTO2, c.ESTATUS, c.LIMITE_CREDITO, c.COND_PAGO_ID, 
				c.TIPO_CLIENTE_ID, c.ZONA_CLIENTE_ID, c.NOMBRE_COMERCIAL, c.FORMA_DE_PAGO_ID, c.SERIE, c.IMPUESTO, c.DOCTOS_MAX, c.RUTA_EMBARQUE, c.CONTADO, c.PCTJ_PRONTOPAGO,
				/*l.MIN_FLTE_PAGADO AS IMPTE_MINIMO_PED*/ c.IMPTE_MINIMO_PED, l.MIN_FLTE_PAGADO AS IMPORTE_MIN_PED_FLETE,	c.IMPORTE_MIN_PED_FLETE AS IMPORTE_MIN_PED_FLETE_CLIENTE, 
				c.DIAS_VENCIMIENTO_PP, c.PASS, c.PEDIDO_WEB_BLOQ, c.CORREO_VENDEDOR, c.TELEFONO_VENDEDOR, 
				c.COND_PAGO_WEB_ID, c.IMPTE_MINIMO_PED_BLOQ, c.DIAS_EXTRA, c.SOLO_VTA_CONTADO, c.COMISION_PAGO_WEB, c.GIRO_ID, l.LOCALIDAD_ID, l.NOMBRE_LOCALIDAD AS LOCALIDAD, l.TIPO_LOCALIDAD, dc.DIR_CLI_ID
				FROM _CLIENTES c 
				INNER JOIN `_BR_EMAILS_CLIENTES` bec ON c.CLIENTE_ID = bec.CLIENTE_ID 
				INNER JOIN _DIRS_CLIENTES dc ON c.CLIENTE_ID= dc.CLIENTE_ID    
				LEFT JOIN _LOCALIDADES l ON dc.LOCALIDAD_ID = l.LOCALIDAD_ID
				WHERE {$condition} AND dc.ES_DIR_PPAL='S' /*AND c.ESTATUS='A'*/ {$passwordCondition} LIMIT 1")->row();		

        // echo $this->db->last_query();
        // exit();
	
		return $user;

    }
}