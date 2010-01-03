<?php defined('_JEXEC') or die('Restricted access');

class Menu_template extends Entity
{
	protected $table_name = '#__menu_template';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
