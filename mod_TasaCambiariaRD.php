<?php 
/**
 * Module to display the Exchange Rate of the Dominican Republic
 * 
 * @package    Máximo Ramírez
 * @subpackage Modules
 * @link 
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * mod_TrasaCambioRD is free software. Can be modified and/or distributed
 * under the same terms of this license.
 */

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
include the helper.php file which contains the class to be used to collect the necessary data
invoke the appropriate helper class method to retrieve the data
include the template to display the output.
*/
require_once( dirname(__FILE__).'/helper.php' );
$infoTasaCambiaria = modTasaCambiariaHelper::getRates($params);
require( JModuleHelper::getLayoutPath( 'mod_TasaCambiariaRD' ) );
?>
