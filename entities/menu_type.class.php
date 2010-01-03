<?php defined('_JEXEC') or die('Restricted access');

class Menu_type extends Entity
{
	protected $table_name = '#__menu_types';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
