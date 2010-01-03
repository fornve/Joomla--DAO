<?php defined('_JEXEC') or die('Restricted access');

class Schema extends Entity
{
	protected $table_name = '#__schemas';
	
	static function Retrieve()
	{
		// needs custom retrieve method
	}
}
