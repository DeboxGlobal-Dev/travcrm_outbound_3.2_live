<?php 
include "../inc.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
header('Cache-Control: max-age=900');
header("Content-Type: application/json");
        
	$from_currency = trim($_POST['from']);
	$to_currency = trim($_POST['to']);
	$amount = trim($_POST['amount']);	
	if($from_currency == $to_currency) {
	 	$data = array('error' => '1');
		echo json_encode( $data );	
		exit;
		
	$converted_currency=currencyConverter($from_currency, $to_currency, $amount);
	$converted_currency;
    }	
function currencyConverter($fromCurrency,$toCurrency,$amount) {	
	$fromCurrency = urlencode($fromCurrency);
	$toCurrency = urlencode($toCurrency);	
	$encode_amount = 1;
	$url  = "https://www.google.com/search?q=".$fromCurrency."+to+".$toCurrency;
	$get = url_get_contents($url);
	$data = preg_split('/\D\s(.*?)\s=\s/',$get);
	$exhangeRate = (float) substr($data[1],0,7);
	$convertedAmount = $amount*$exhangeRate;
	$data = array( 'exhangeRate' => $exhangeRate, 'convertedAmount' =>$convertedAmount, 'fromCurrency' => strtoupper($fromCurrency), 'toCurrency' => strtoupper($toCurrency));
	echo json_encode( $data );	
}
?>
