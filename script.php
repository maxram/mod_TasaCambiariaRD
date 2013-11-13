<?php 
/*------------------------------------------------------------------------

# mod_TasaCambiariaRD
# author    Máximo Ramírez
# Copyright Copyright (C) 2013 omixam. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: https://github.com/maxram
# Technical Support:  Issues - https://github.com/maxram/mod_TasaCambiariaRD/issues

-------------------------------------------------------------------------*/
//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Script for Module TasaCambiaria 
 */
class mod_TasaCambiariaRDInstallerScript
{	
	/**
         * Method to install the extension
         * $parent is the class calling this method
         *
         * @return void
         */
        function install($parent) 
        {
                echo '<p>The module has been installed</p>';
        }
 
        /**
         * Method to uninstall the extension
         * $parent is the class calling this method
         *
         * @return void
         */
        function uninstall($parent) 
        {
                echo '<p>The module has been uninstalled</p>';
        }
 
        /**
         * Method to update the extension
         * $parent is the class calling this method
         *
         * @return void
         */
        function update($parent) 
        {
                echo '<p>The module has been updated to version' . $parent->get('manifest')->version) . '</p>';
        }
 
        /**
         * Method to run before an install/update/uninstall method
         * $parent is the class calling this method
         * $type is the type of change (install, update or discover_install)
         *
         * @return void
         */
        function preflight($type, $parent) 
        {
                echo '<p>Anything here happens before the installation/update/uninstallation of the module</p>';
        }
 
        /**
         * Method to run after an install/update/uninstall method
         * $parent is the class calling this method
         * $type is the type of change (install, update or discover_install)
         *
         * @return void
         */
        function postflight($type, $parent) 
        {
                echo '<p>Anything here happens after the installation/update/uninstallation of the module</p>';
        }
}
?>
