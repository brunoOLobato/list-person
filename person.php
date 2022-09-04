<?php

/**
 * @package  PersonPlugin
 */
/*
Plugin Name: Person 
Description: Plugin for Person
Version: 1.0.2
Author: Bruno Lobato
Author URI: http://github.com/brunoOLobato
License: CTP
Text Domain: person-plugin
*/

// If this file is called firectly, abort!!!
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
	require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_person_plugin()
{
	Inc\Base\ActivatePerson::activate();
}
register_activation_hook(__FILE__, 'activate_person_plugin');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_person_plugin()
{
	Inc\Base\DeactivatePerson::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_person_plugin');

/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('Inc\\InitPerson')) {
	Inc\InitPerson::registerServices();
}

function debugPerson($array_data)
{
	print("<pre>" . print_r($array_data, true) . "</pre>");
}
