<?php defined('_JEXEC') or die('Restricted access');

class Module extends Entity
{
	protected $table_name = '#__modules';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
