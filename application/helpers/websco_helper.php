<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/******
 *
 *@author  	Carlos Guevara
 *@email 	dejitaru@gmail.com
 *
 *******/

function form_select_nums($name, $values, $inicio = 1, $selected = NULL)
{
	$html = '';
	if (is_array($values)) {
		foreach ($values as $k => $v) {
			$html .= '<option value="' . $k . '">' . $v . '</option>';
		}
	} else {
		for ($i = $inicio; $i <= $values; $i++) {
			$html .= '<option value="' . $i . '">' . $i . '</option>';
		}
	}
	return $html;
}

function form_select_options($values, $selected = NULL)
{
	$html = '';
	foreach ($values as $key => $value) {
		$html .= '<option value="' . $key . '">' . $value . '</option>';
	}
	return $html;
}
function form_select_db($values, $key = 'id', $value = 'nombre', $selected = NULL)
{
	$html = '';
	foreach ($values->result() as $item) {
		$s = ($item->$key == $selected) ? 'selected="selected"' : '';
		$html .= '<option value="' . $item->$key . '" ' . $s . '>' . $item->$value . '</option>';
	}
	return $html;
}
function form_select_db2($values, $key = 'id', $value = 'nombre', $selected = NULL)
{
	$html = '';
	foreach ($values as $item) {
		$s = ($item->$key == $selected) ? 'selected="selected"' : '';
		$html .= '<option data-row="' . json_encode($item) . '" value="' . $item->$key . '" ' . $s . '>' . $item->$value . '</option>';
	}
	return $html;
}

function date_cute($date, $full = FALSE)
{
	$date = date('Y-n-d-h-i-s', strtotime($date));
	$date = explode('-', $date);
	$meses  = array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	if (!$full) {
		//return $date[2].' ' .$date[1].' '.$date[0];
		return $date[2] . ' ' . $meses[$date[1]] . ' ' . $date[0];
	} else {
		return $date[2] . ' de ' . $meses[$date[1]] . ' ' . $date[0] . ' a las ' . $date[3] . ':' . $date[4];
	}
}


/*function date_diff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}*/

function foto_default($search = '', $default = '')
{
	if (file_exists($search)) {
		return $search;
	}
	return $default;
}


function date_today($type = 'short')
{
	$date	= date('Y-n-d');
	$meses  = array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	return 	$date[2] . ' ' . $meses[$date[1]] . ' ' . $date[0];
}

function date_encabezado()
{
	$date	= date('N-j-n');
	$date = explode('-', $date);
	$meses  = array('', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$dias   = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
	return 	$dias[$date[0]] . ' ' . $date[1] . ' de ' . $meses[$date[2]];
}

function date_tomorrow()
{
	return date("Y-m-d", strtotime($start . "+1 days"));
}
/*
function date_add($start,$days){
	return date("Y-m-d", strtotime($start ."+$days days" ));
}*/

function form_select_months($name, $selected = NULL)
{
	$html = '';
	$meses  = array('', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	for ($i = 1; $i <= 12; $i++) {
		if ($selected != $i) {
			$html .= '<option value="' . $i . '">' . $meses[$i] . '</option>';
		} else {
			$html .= '<option value="' . $i . '" selected="selected">' . $meses[$i] . '</option>';
		}
	}
	return $html;
}
function form_select_year($name, $n, $selected = NULL)
{
	$html = '';
	$current_year = date('Y');
	$n = $current_year + $n;
	for ($i = $current_year; $i < $n; $i++) {
		if ($selected != $i) {
			$html .= '<option value="' . $i . '">' . $i . '</option>';
		} else {
			$html .= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
		}
	}
	$html .= '</select>';
	return $html;
}

function class_error($is_error, $class_ok = 'ok', $class_error = 'error')
{
	if (count($_POST) > 0) {
		if (strlen($is_error) > 0) {
			echo $class_error;
		} else {
			echo $class_ok;
		}
	}
}

function format_filesize($size)
{
	$units = array(' Bytes', ' KB', ' MB', ' GB', ' TB');
	for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
	return round($size, 2) . $units[$i];
}

function random_str($length)
{
	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	srand((float)microtime() * 1000000);
	$i = 0;
	$pass = '';

	while ($i < $length) {
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}

	return $pass;
}

function file_extension($filename)
{
	return substr(strrchr($filename, '.'), 1);
}


/* Develeoped by: faisal ahmed <thephpx(at)gmail.com–> */
function google_translate($api_key, $text, $from_lang, $to_lang)
{
	$link = "https://www.googleapis.com/language/translate/v2?key=" . $api_key . "&amp;source=" . $from_lang . "&amp;target=" . $to_lang . "&amp;q=" . $text;
	$response = file_get_contents($link);
	$array = json_decode($response);
	return $array->data->translations[0]->translatedText;
}

function firstOfMonth()
{
	return date("m/d/Y", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
}
function add_assets(&$assets, $new_asset = '')
{
	if (is_array($new_asset)) {
		foreach ($new_asset as $asset) {
			$ext = end(explode(".", $asset));
			array_push($assets[$ext], $asset);
		}
	} else {
		$ext = end(explode(".", $new_asset));
		array_push($assets[$ext], $new_asset);
	}
	return TRUE;
}

function shared_url()
{
	$CI = &get_instance();
	return $CI->config->item('shared_url');
}

function my_month($n)
{
	$meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	return $meses[$n];
}

function image_resize($image_path, $width = 0, $height = 0, $new_image_path = 'tb/')
{
	//Get the Codeigniter object by reference
	$CI = &get_instance();

	//Alternative image if file was not found
	if (!file_exists($image_path))
		$image_path = 'images/file_not_found.jpg';

	//The new generated filename we want
	$fileinfo = pathinfo($image_path);
	$new_image_path = $new_image_path . $fileinfo['filename'] . '.' . $fileinfo['extension'];

	//The first time the image is requested
	//Or the original image is newer than our cache image
	if ((!file_exists($new_image_path)) || filemtime($new_image_path) < filemtime($image_path)) {
		$CI->load->library('image_lib');

		//The original sizes
		$original_size = getimagesize($image_path);
		$original_width = $original_size[0];
		$original_height = $original_size[1];
		$ratio = $original_width / $original_height;

		//The requested sizes
		$requested_width = $width;
		$requested_height = $height;

		//Initialising
		$new_width = 0;
		$new_height = 0;

		//Calculations
		if ($requested_width > $requested_height) {
			$new_width = $requested_width;
			$new_height = $new_width / $ratio;
			if ($requested_height == 0)
				$requested_height = $new_height;

			if ($new_height < $requested_height) {
				$new_height = $requested_height;
				$new_width = $new_height * $ratio;
			}
		} else {
			$new_height = $requested_height;
			$new_width = $new_height * $ratio;
			if ($requested_width == 0)
				$requested_width = $new_width;

			if ($new_width < $requested_width) {
				$new_width = $requested_width;
				$new_height = $new_width / $ratio;
			}
		}

		$new_width = ceil($new_width);
		$new_height = ceil($new_height);

		//Resizing
		$config = array();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_path;
		$config['new_image'] = $new_image_path;
		$config['maintain_ratio'] = FALSE;
		$config['height'] = $new_height;
		$config['width'] = $new_width;
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();

		//Crop if both width and height are not zero
		if (($width != 0) && ($height != 0)) {
			$x_axis = floor(($new_width - $width) / 2);
			$y_axis = floor(($new_height - $height) / 2);

			//Cropping
			$config = array();
			$config['source_image'] = $new_image_path;
			$config['maintain_ratio'] = FALSE;
			$config['new_image'] = $new_image_path;
			$config['width'] = $width;
			$config['height'] = $height;
			$config['x_axis'] = $x_axis;
			$config['y_axis'] = $y_axis;
			$CI->image_lib->initialize($config);
			$CI->image_lib->crop();
			$CI->image_lib->clear();
		}
	}
	return $new_image_path;
}

function truncate_str($str, $maxlen)
{
	if (strlen($str) <= $maxlen) return $str;

	$newstr = substr($str, 0, $maxlen);
	if (substr($newstr, -1, 1) != ' ') $newstr = substr($newstr, 0, strrpos($newstr, " "));

	return $newstr;
}

function delete_upload($file)
{
	$CI = &get_instance();
	@unlink($CI->config->item('upload_path') . '/' . $file);
}

function upload($field, $path, $new_name = NULL, $default = NULL)
{
	$CI = &get_instance();
	if ($_FILES[$field]['size'] > 0) {
		$ext = end(explode(".", $_FILES[$field]['name']));
		$filename = url_title($_FILES[$field]['name']);
		$config['upload_path'] = $CI->config->item('upload_path') . $path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['file_name'] = random_str(10) . '.' . $ext;
		$config['overwrite'] = TRUE;
		$CI->load->library('upload', $config);
		if ($CI->upload->do_upload($field)) {
			return $config['file_name'];
		} else {

			return NULL;
		}
	} else {
		return NULL;
	}
}


/**
 * Consumir sevicio web soap
 * Empresa => 2 test | 1 produccion
 * op => Nombre de la funcion a consumir
 * cadena => String concatenado por | etiqueta => valor
 */
function wdsl($empresa = 2,  $op, $cadena)
{
	$key1 = "berny";
	$key2 = "distribuidora";
	$masterKey = strtoupper(sha1($key1) . sha1($key2));

	$xml_post_string = "<?xml version='1.0' encoding='utf-8'?>
		<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>
		  <soap:Body>
			<{$op} xmlns='http://bernydistribuidora.com.mx/Serviciosberny/'>
			  <pKey>{$masterKey}</pKey>
			  <pEmpresa>{$empresa}</pEmpresa>
			  <pCadena>{$cadena}</pCadena>
			</{$op}>
		  </soap:Body>
		</soap:Envelope>";   // data from the form, e.g. some ID number

	$headers = array(
		"Content-type: text/xml;charset=\"utf-8\"",
		"Accept: text/xml",
		"Cache-Control: no-cache",
		"Pragma: no-cache",
		"SOAPAction: http://bernydistribuidora.com.mx/Serviciosberny/{$op}",
		"Content-length: " . strlen($xml_post_string),
	); //SOAPAction: your op URL
	$url = URL_APP_SERVICIO;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "{$url}?op={$op}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if ($httpCode != 200) {
		return "|{'estatus':0,'message':'" . curl_error($ch) . "','data':null}|";
	}
	curl_close($ch);
	return $response;
}

function callApi($url, $payload)
{
	$headers = array(
		'Content-Type:application/json',
		'Authorization: Basic ' . base64_encode("user:password"), // place your auth details here
		"Accept: application/json",
		"Cache-Control: no-cache",
		"Pragma: no-cache",
	);


	$username = "admin";
	$password = "12345";
	$process = curl_init(URL_API_CUSTOMER . $url); //your API url
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($process, CURLOPT_HEADER, false);
	curl_setopt($process, CURLOPT_HEADER, 1);
	curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_POST, true);
	curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($payload));
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	$return = curl_exec($process);
	curl_close($process);
	list($header, $body) = explode("\r\n\r\n", $return, 2);
	return  json_decode($body);	
}


function send_email($email, $subject, $message)
{
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	mail($email, $subject, $message, $headers);
}

/**
 * Funcion to send mail notification
 */
function sendMail($to, $subject, $message, $isNotification = FALSE, $address = null)
{
	$ci = &get_instance();
	$ci->load->library('email');
	$config = array(
		'protocol' => 'smtp',
		'smtp_host' => ($isNotification) ? 'smtp.hostinger.mx' : 'in.mailjet.com',
		'smtp_port' => 587,
		'smtp_user' => ($isNotification) ? 'notificaciones@berny.mx' : 'd717dfa5efa2e347c8133958572c2d39',
		'smtp_pass' => ($isNotification) ? 'Notificaciones1.' : '1791afa646344f24f29bb92bcdfbe3c4',
		'mailtype'  => 'html',
		'charset'   => 'utf-8',
		'_smtp_auth' => TRUE,
		'mailtype'  => 'html',
	);
	$ci->email->initialize($config);
	if ($isNotification) {
		$ci->email->from('notificaciones@berny.mx', 'Berny-Notificaciones');
	} else {
		$ci->email->from('web@berny.mx', 'Berny-web');
	}
	$ci->email->to($to);

	if (!empty($address)) {
		$ci->email->bcc($address);
	}


	$ci->email->subject($subject);
	$ci->email->message($message);

	if ($ci->email->send()) {
		return 1;
	} else {
		return 0;
	}
}

function strPad($value, $cant = 15, $type = '0')
{
	return str_pad($value, $cant, $type, STR_PAD_LEFT);
}

function encrypt($string, $key = "@c-developer")
{
	$result = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return base64_encode($result);
}

function decrypt($string, $key = "@c-developer")
{
	$result = '';
	$string = base64_decode($string);
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}

/**
 * Replace special characters with blanks
 */
function replaceSpecialCharacters($string)
{
	return preg_replace('([^A-Za-z0-9 ])', ' ', $string);
}

/**
 * Reemplaza todos los acentos por sus equivalentes sin ellos
 *
 * @param $string
 *  string la cadena a sanear
 *
 * @return $string
 *  string saneada
 */
function sanear_string($string)
{
	$string = trim($string);

	$string = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		$string
	);

	$string = str_replace(
		array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		$string
	);

	$string = str_replace(
		array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		$string
	);

	$string = str_replace(
		array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		$string
	);

	$string = str_replace(
		array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		$string
	);

	$string = str_replace(
		array('ñ', 'Ñ', 'ç', 'Ç'),
		array('n', 'N', 'c', 'C',),
		$string
	);

	//Esta parte se encarga de eliminar cualquier caracter extraño
	$string = str_replace(
		array(
			"\\", "¨", "º", "-", "~",
			"#", "@", "|", "!", "\"",
			"·", "$", "%", "&", "/",
			"(", ")", "?", "'", "¡",
			"¿", "[", "^", "`", "]",
			"+", "}", "{", "¨", "´",
			">", "<", ";", ",", ":",
			".", " "
		),
		'',
		$string
	);
	return strtoupper(preg_replace('([^A-Za-z0-9 ])', ' ', $string));
}

function startsWith($string, $startString)
{
	$len = strlen($startString);
	return (substr($string, 0, $len) === $startString);
}

function getDateTime()
{
	return ' Fecha: ' . date('Y-m-d H:i:s');
}

/**
 * Funcion para obtener el consecutivo para las tablas generales
 * principalmente enfocado para _CLIENTES, _DIRS_CLIENTES, _BR_EMAILS_CLIENTE
 * 
 */
function nextFolio()
{
	$ci = &get_instance();
	$next =  $ci->db->query("SELECT value as next FROM folios WHERE serie = 'NEXT' AND tabla = 'GENERAL'")->row()->next;
	return ($next) ? (intval($next + 1) * -1) : -1;
}

/**
 * Function to generate customer Logs
 */
function customerLogs($id, $old_id, $message = null,  $data = null, $type = 'REGISTRO', $clave = null)
{
	$ci = &get_instance();
	$data = json_decode(json_encode($data));
	if (!empty($data)) {
		if ($type == 'REGISTRO') {
			$data->data->CLIENTE_ID = base64_decode($data->data->CLIENTE_ID);
			$id = abs($data->data->CLIENTE_ID);
			$old_id = abs($data->data->CLIENTE_ID);
			$data->data->CLAVE_CLIENTE = base64_decode($data->data->CLAVE_CLIENTE);
		}
	} else {
		$data = NULL;
	}
	$today = date('Y-m-d H:i:s');
	$id = abs($id);
	$old_id = abs($old_id);
	$data = json_encode($data);
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!empty($data)) {
		$sql = "INSERT INTO customer_registration (customer_id, old_id, `message`, `data`, `type`, active, created_at, updated_at, ip, clave)	VALUES($id, $old_id, '{$message}',  '{$data}', '{$type}', 1, '{$today}', '{$today}', '{$ip}', '{$clave}')";
		$res = $ci->db->query($sql);
		return $res;
	}
	return true;
}

/**
 * Function to generate order tracking
 */
function setOrderTracking($data)
{
	$ci = &get_instance();
	$items = json_decode(json_encode($data));
	$response = json_encode($items);
	if (!empty($data)) {
		$sql = "INSERT INTO order_tracking (order_id, customer_id, total, shipping_cost, `status`, `data`) 
		VALUES ($items->order_id, $items->customer_id, $items->total, $items->shipping_cost, '{$items->status}', '{$response}')";
		$res = $ci->db->query($sql);
		return $res;
	}
	return true;
}

function statusEquivalents($status = 0)
{
	$return = "En edición";
	switch ($status) {
		case 0:
			$return = "En edición";
			break;
		case 1:
			$return = "En espera de proceso";
			break;
		case 2:
			$return = "En proceso";
			break;
		case 3:
		case 11:
			$return = "Cancelado";
			break;
		case 4:
			$return = "Por pagar";
			break;
		case 5:
			$return = "Confirmación de pago";
			break;
	}
	return $return;
}

function generateRandomString($strength = 17, $isConekta = false)
{
	$random_string = '';
	$permitted_chars = (($isConekta)) ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '0123456789';
	$input_length = strlen($permitted_chars);
	for ($i = 0; $i < $strength; $i++) {
		$random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
		$random_string .= $random_character;
	}
	return $random_string;
}

function avatarInitial($name)
{
	$acronym = null;
	$word = null;
	$words = preg_split("/(\s|\-|\.)/", $name);
	foreach ($words as $w) {
		$acronym .= substr($w, 0, 1);
	}
	$word = $word . $acronym;
	return $word;
}

function elimina_acentos($text)
{
	$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
	$text = strtolower($text);
	$patron = array(
		// Espacios, puntos y comas por guion
		//'/[\., ]+/' => ' ',

		// Vocales
		'/\+/' => '',
		'/&agrave;/' => 'a',
		'/&egrave;/' => 'e',
		'/&igrave;/' => 'i',
		'/&ograve;/' => 'o',
		'/&ugrave;/' => 'u',

		'/&aacute;/' => 'a',
		'/&eacute;/' => 'e',
		'/&iacute;/' => 'i',
		'/&oacute;/' => 'o',
		'/&uacute;/' => 'u',

		'/&acirc;/' => 'a',
		'/&ecirc;/' => 'e',
		'/&icirc;/' => 'i',
		'/&ocirc;/' => 'o',
		'/&ucirc;/' => 'u',

		'/&atilde;/' => 'a',
		'/&etilde;/' => 'e',
		'/&itilde;/' => 'i',
		'/&otilde;/' => 'o',
		'/&utilde;/' => 'u',

		'/&auml;/' => 'a',
		'/&euml;/' => 'e',
		'/&iuml;/' => 'i',
		'/&ouml;/' => 'o',
		'/&uuml;/' => 'u',

		'/&auml;/' => 'a',
		'/&euml;/' => 'e',
		'/&iuml;/' => 'i',
		'/&ouml;/' => 'o',
		'/&uuml;/' => 'u',

		// Otras letras y caracteres especiales
		'/&aring;/' => 'a',
		'/&ntilde;/' => 'n',

		// Agregar aqui mas caracteres si es necesario

	);

	$text = preg_replace(array_keys($patron), array_values($patron), $text);
	return $text;
}

function responseJSON($code, $status, $message, $array)
{
	$ci = &get_instance();
	return $ci->output
		->set_content_type('application/json')
		->set_status_header($code)
		->set_output(json_encode(array(
			'status' => $status,
			'data' => $array,
			'message' => $message
		)));
	exit();
}

/**
 * Create a URL slug from a string
 *
 * @param string $str String to create slug from (str)
 * @param mixed $limit Limit the number of characters returned (optional)
 * @return string
 * @author Steve Grunwell
 */
function create_slug($str, $limit = 64)
{

	/*
	  Hash of common accented characters and their best URL-friendly equivalents
	  Credit to sales@mk2solutions.com on http://php.net/manual/en/function.strtr.php
	*/
	$replacements = array(
		'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
		'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
		'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
		'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
		'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
		'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
		'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f', '&' => 'and'
	);

	$str = strtr($str, $replacements); // Replace accented/special characters
	$str = preg_replace('/\s+/', '-', trim($str)); // Trim and remove spaces
	$str = str_replace('_', '-', $str); // Underscores to dashes
	$str = preg_replace('/[^a-z0-9-]/i', '', strtolower($str)); // Only alpha-numeric and dashes are permitted
	$str = preg_replace('/-+/', '-', $str); // Prevent 2+ dashes from appearing together

	// Limit the number of characters
	if (intval($limit) > 0) {
		$str = substr($str, 0, intval($limit));
	}

	// Don't end in a dash
	if (substr($str, -1, 1) === '-') {
		$str = substr($str, 0, -1);
	}

	return $str;
}
