<?php

/**
 * @package  PersonPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseControllerPerson;

/**
 * 
 */
class EnqueuePerson extends BaseControllerPerson
{
	public function register()
	{
		add_action('admin_enqueue_scripts', array($this, 'add_assets_admin'));
		add_action('wp_enqueue_scripts', array($this, 'add_assets_front'));
	}

	function add_assets_admin()
	{
		// enqueue all our scripts
		wp_enqueue_style('select2_style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css');
		wp_enqueue_style('person_style', $this->plugin_url . 'assets/css/style.css');
		wp_enqueue_script('person_adminJS', $this->plugin_url . 'assets/js/js-admin.js', ['jquery'], '', true);
		wp_enqueue_script('select2_adminJS', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', ['jquery'], '', true);
	}

	/**
	 * Add front end link to head 
	 * Add scripts to footer 
	 */
	function add_assets_front()
	{
		wp_enqueue_style('person_frontCSS', $this->plugin_url . 'assets/css/main.css', [], '', 'all');
		wp_enqueue_script('person_frontJS', $this->plugin_url . 'assets/js/bundle.js', ['jquery'], '', true);

		wp_localize_script('person_frontJS', 'usAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
	}
}
