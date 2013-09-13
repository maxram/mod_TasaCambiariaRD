<?php
/**
 * Helper class para el modulo Tasa Cambio RD
 * 
 * @package    Máximo Ramírez
 * @subpackage Modules
 * @link 
 * @license        GNU/GPL V3   http://www.gnu.org/licenses/gpl.html 
 * mod_TrasaCambioRD es software libre. Puede ser modificado y/o distribuido
 * bajo los mismos terminos de misma licencia.
 */

require_once('libs/PHPExcel.php');
//http://www.bancentral.gov.do/estadisticas.asp?a=Mercado_Cambiario
define('BCURLTC','http://www.bancentral.gov.do/tasas_cambio/');
/**
 * Se publica diariamente antes de las 6:30 p.m.
 */
//define('USD_XLS',BCURLTC.'TASA_DOLAR_REFERENCIA_MC.XLS');
define('USD_XLS',BCURLTC.'DOLAR_VENTANILLA_SONDEO.xls');
/**
 * Se publica diariamente antes de las 12:30 p.m.
 * se supone que hay un excel al igual que el del dolar...
 */ 
define('EUR_XLS',BCURLTC.'EURO_VENTANILLA_SONDEO.xls');
// All currencies
define('ALL_XLS',BCURLTC.'TASAS_CONVERTIBLES_OTRAS_MONEDAS.xls');

class modTasaCambiariaHelper
{
    /**
     * PHPExcel needs a local file... create a temp xls
     * @param (string) $url url to the excel to download.
     * @return (string) the name of the temp file. 
     */
    function getExcel($url){
        $contents = file_get_contents($url);
        $filename = 'temp'.time().'.xls';
        file_put_contents($filename, $contents);
        return $filename;   
    }
    
    /**
     * Obtiene los tipos de cambio, la lectura  proporcionado por el  Banco Central
     * @param $type el tipo de moneda de conseguir, por defecto se utiliza Dólar y Euro
     * @return (array) con los valores de Compra y Venta 
     */
    function getCurrencyRates($type){
        for($i=0; $i < count($type); $i++){
            $filename = modTasaCambiariaHelper::getExcel(($type[$i] == 'Dólar') ? USD_XLS : EUR_XLS);
            $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow();
            //print_r($highestRow);
            // D == compra E == Venta
            $compra = $objWorksheet->getCell('D'.$highestRow)->getValue();
            $venta = $objWorksheet->getCell('E'.$highestRow)->getValue();
            unlink($filename);
            $tasaCambio[$type[$i]][$i] = number_format($compra, 2, '.', '');
            $tasaCambio[$type[$i]][$i+1] = number_format($venta, 2, '.', '');
        }
        return array($type, $tasaCambio);
    }
    
    /*Get Rates*/
    function getRates($params){
      return modTasaCambiariaHelper::getCurrencyRates(array('Dólar','Euro')); 
    }
    
    /*
      * Obtiene todas las monedas, sólo el valor de compra (C),
      * Ya que eso es lo que el Banco Central dará en los XLS
      * @return (array) con los valores de C para cada tipo del Banco Central dado.
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
}
?>
