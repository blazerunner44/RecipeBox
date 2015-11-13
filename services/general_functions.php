<?php
//Escapes all indexes of an array
function escape($con, $array){
	foreach($array as $key => $value){
		$array[$key] = mysqli_real_escape_string($con, $value);
	}
	return $array;
}

//Creates JSON from status code and array
function createJSON($code, $response=''){
	$return = array('status' => $code, 'response' => $response);
	return json_encode($return);
}

//Preforms an HTTP GET request
function http_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

//Checks if promo code exists -- returns percent off if it exists
function validate_promo($code){
	$list = array('10off' => 0.10); //List of valid promo codes
	if(array_key_exists($code, $list)){
		return $list[$code];
	}
	return False;
}

//Checks if an account with the supplied email exists
function account_exists($con, $email){
	$query = mysqli_query($con, "SELECT COUNT(email) as count FROM users WHERE email='$email'");
	$result = mysqli_fetch_array($query);
	if($result['count'] != 0){
		return True;
	}
	return False;
}

//Returns a random number with a specified number of digits
function random_number($digits) {
    $min = pow(10, $digits - 1);
    $max = pow(10, $digits) - 1;
    return mt_rand($min, $max);
}

//Verifies the user is authenticated (must be called after session_start())
function verifyAuth(){
	if(!(isset($_SESSION['auth']))){
		echo createJSON(401);
		exit;
	}
	return True;
}
?>