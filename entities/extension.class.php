<?php defined('_JEXEC') or die('Restricted access');

class Extension extends Entity
{
	protected $table_name = '#__extensions';
	protected $id_name = 'extension_id';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
