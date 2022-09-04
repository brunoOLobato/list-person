<?php

/**
 * @package  PersonPlugin
 */

namespace Inc\Base;

class ActivatePerson
{
	public static function activate()
	{
		flush_rewrite_rules();
	}
}
