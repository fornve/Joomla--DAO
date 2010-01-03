<?php defined('_JEXEC') or die('Restricted access');

class Banner_client extends Entity
{
	protected $table_name = '#__bannerclient';
	protected $id_name = 'cid';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
