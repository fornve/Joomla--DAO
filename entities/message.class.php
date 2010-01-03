<?php defined('_JEXEC') or die('Restricted access');

class Message extends Entity
{
	protected $table_name = '#__messages';
	protected $id_name = 'message_id';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
