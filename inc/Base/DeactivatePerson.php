<?php

/**
 * @package  PersonPlugin
 */

namespace Inc\Base;

class DeactivatePerson
{
	public static function deactivate()
	{
		flush_rewrite_rules();
	}
}
