<?php 
/**
 * Modulo para mostrar la Tasa Cambiaria de la República Dominicana
 * 
 * @package    Máximo Ramírez
 * @subpackage Modules
 * @link 
 * @license        GNU/GPL V3   http://www.gnu.org/licenses/gpl.html 
 * mod_TrasaCambioRD es software libre. Puede ser modificado y/o distribuido
 * bajo los mismos terminos de misma licencia.
 
 */

//no direct access
defined( '_JEXEC' ) or die( 'Acceso Restringido' );

require_once( dirname(__FILE__).'/helper.php' );
$infoTasaCambiaria = modTasaCambiariaHelper::getRates($params);
require( JModuleHelper::getLayoutPath( 'mod_TasaCambiariaRD' ) );
?>
