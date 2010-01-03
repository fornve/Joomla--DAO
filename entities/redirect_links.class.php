<?php defined('_JEXEC') or die('Restricted access');

class Redirect_links extends Entity
{
	protected $table_name = '#__redirect_links';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
