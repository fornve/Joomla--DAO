<?php defined('_JEXEC') or die('Restricted access');

class Update_category extends Entity
{
	protected $table_name = '#__update_categories';
	protected $id_name = 'categoryid';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
