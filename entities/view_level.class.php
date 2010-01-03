<?php defined('_JEXEC') or die('Restricted access');

class View_level extends Entity
{
	protected $table_name = '#__viewlevels';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
