<?php 
require_once('libs/PHPExcel.php');
//http://www.bancentral.gov.do/estadisticas.asp?a=Mercado_Cambiario
define('BCURLTC','http://www.bancentral.gov.do/tasas_cambio/');
// Se publica diariamente antes de las 6:30 p.m.
define('USD_XLS',BCURLTC.'TASA_DOLAR_REFERENCIA_MC.XLS');
/**
 * Se publica diariamente antes de las 12:30 p.m.
 * se supone que hay un excel al igual que el del dolar...
 */ 
define('EUR_XLS',BCURLTC.'EURO_VENTANILLA_SONDEO.xls');
// All currencies
define('ALL_XLS',BCURLTC.'TASAS_CONVERTIBLES_OTRAS_MONEDAS.xls');

/**
 * PHPExcel needs a local file... create a temp xls
 * @param (string) $url url to the excel to download.
 * @return (string) the name of the temp file. 
 */
function getExcel($url){
	$contents = file_get_contents($url);
	$filename = 'temp'.time().'xls';
	file_put_contents($filename, $contents);
	return $filename;
	
}

/**
 * Gets the USD Rates
 * @return (array) with the values for C and V
 */
function getUSDRates(){
	return _getCurrencyRates('USD');
}

/**
 * Gets the EUR Rates
 * @return (array) with the values for C and V
 */
function getEURRates(){
	return _getCurrencyRates('EUR');
}

/**
 * Gets the Currency Rates, reading the excel provided by Banco Central
 * @param $type the type of currency to get, default is USD, if something else, it will get the EUR Rates
 * @return (array) with the values for C and V 
 */
function _getCurrencyRates($type='USD'){
	$filename = getExcel(($type == 'USD') ? USD_XLS : EUR_XLS);
	$objPHPExcel = PHPExcel_IOFactory::load($filename);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$highestRow = $objWorksheet->getHighestRow();
	// D == compra E == Venta
	$compra = $objWorksheet->getCell('D'.$highestRow)->getValue();
	$venta = $objWorksheet->getCell('E'.$highestRow)->getValue();
	unlink($filename);
	return array('C'=>$compra,'V'=>$venta);
}

/**
 * Get all the currencies, only the purchase value (C),
 * since that is what the banco central will give in the XLS
 * @return (array) with the C values for each rate the Banco Central gives.
 */
function getAllCurrencyRates(){
	$filename = getExcel(ALL_XLS);
	$objPHPExcel = PHPExcel_IOFactory::load($filename);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = $objWorksheet->getHighestColumn(); 
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	$currencies = array();
	for($i = 3; $i < $highestColumnIndex; $i++ ){
		$key = $objWorksheet->getCellByColumnAndRow($i,3)->getValue();
		$val = $objWorksheet->getCellByColumnAndRow($i,$highestRow)->getValue();
		$currencies[$key] = $val; 
	}
	return $currencies;
}
