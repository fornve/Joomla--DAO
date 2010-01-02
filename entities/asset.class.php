<?php defined('_JEXEC') or die('Restricted access');

class Asset extends Entity
{
	protected $table_name = '#__assets';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
