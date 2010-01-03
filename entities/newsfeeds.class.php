<?php defined('_JEXEC') or die('Restricted access');

class Newsfeeds extends Entity
{
	protected $table_name = '#__newsfeeds';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
