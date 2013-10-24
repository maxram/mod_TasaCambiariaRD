<?php 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
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
