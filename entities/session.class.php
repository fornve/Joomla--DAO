<?php defined('_JEXEC') or die('Restricted access');

class Session extends Entity
{
	protected $table_name = '#__sessions';
	protected $id_name = 'session_id';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
