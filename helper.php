<?php
/**
 *Helper class for the module RD rate change
 * 
 * @package    Máximo Ramírez
 * @subpackage Modules
 * @link 
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * mod_TrasaCambioRD is free software. Can be modified and/or distributed
 * under the same terms of this license.
 */

require_once('libs/PHPExcel.php');
//http://www.bancentral.gov.do/estadisticas.asp?a=Mercado_Cambiario
define('BCURLTC','http://www.bancentral.gov.do/tasas_cambio/');
/**
 * It is published daily by 6:30 p.m.
 */
//define('USD_XLS',BCURLTC.'TASA_DOLAR_REFERENCIA_MC.XLS');
define('USD_XLS',BCURLTC.'DOLAR_VENTANILLA_SONDEO.xls');
/**
 * It is published daily before 12:30 p.m.
 * Is supposed to be a excel like the the dollar ...
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
     *Gets the exchange rates, the reading provided by the Central Bank of Dominican Republic
     * @param $type the currency to get, by default it uses Dollar and Euro
     * @return (array) with the values ​​of Purchase and Sale
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
      * Gets all the coins, only the purchase price (C),
      * Since that's what the Central Bank will in XLS
      * @return (array) with the values ​​of C for each Central Bank rate given.
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
