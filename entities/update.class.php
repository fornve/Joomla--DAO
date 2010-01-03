<?php defined('_JEXEC') or die('Restricted access');

class Update extends Entity
{
	protected $table_name = '#__updates';
	protected $id_name = 'update_id';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
