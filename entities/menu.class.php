<?php defined('_JEXEC') or die('Restricted access');

class Menu extends Entity
{
	protected $table_name = '#__menu';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
