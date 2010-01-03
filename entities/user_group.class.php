<?php defined('_JEXEC') or die('Restricted access');

class User_group extends Entity
{
	protected $table_name = '#__usergroups';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
