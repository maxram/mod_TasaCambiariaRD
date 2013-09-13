/**
 * @package    Máximo Ramírez
 * @subpackage Modules
 * @link 
 * @license        GNU/GPL V3   http://www.gnu.org/licenses/gpl.html 
 * mod_TrasaCambioRD es software libre. Puede ser modificado y/o distribuido
 * bajo los mismos terminos de misma licencia.
 */
<?php 
// No Acceso Directo
defined( '_JEXEC' ) or die( 'Acceso Restringido' ); 
$document = JFactory::getDocument();
$document->addStyleSheet($this->baseurl.'/modules/mod_TasaCambiariaRD/tmpl/estilos.css');

	$type = $infoTasaCambiaria[0];
	$tasaCambio = $infoTasaCambiaria[1];
	
	echo '
	<table id="tasaCambiaria"> 
	<tr>
		<td></td>
		<th>'.'Compra'.'</td>
		<th>'.'Venta'.'</td>
	</tr>';

	for($i=0; $i <= count($type); $i++)
	{
		echo '
		<tr>
			<td>'.$type[$i].'</td>
		    <td>'.$tasaCambio[$type[$i]][$i].'</td>
			<td>'.$tasaCambio[$type[$i]][$i+1].'</td>
		    </tr>	        
		    ';
	}
	echo '</table>';
?>
