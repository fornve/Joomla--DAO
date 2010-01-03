<?php defined('_JEXEC') or die('Restricted access');

class Component extends Entity
{
	protected $table_name = '#__components';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
