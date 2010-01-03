<?php defined('_JEXEC') or die('Restricted access');

class Banner extends Entity
{
	protected $table_name = '#__banner';
	protected $id_name = 'bid';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
