<?php defined('_JEXEC') or die('Restricted access');

class User extends Entity
{
	protected $table_name = '#__users';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
