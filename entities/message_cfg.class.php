<?php defined('_JEXEC') or die('Restricted access');

class Message_cfg extends Entity
{
	protected $table_name = '#__messages_cfg';
	
	static function Retrieve( $user_id, $cfg_name )
	{
		if( !$user_id || !$cfg_name )
			return null;

		$entity = new Entity();
		$query = "SELECT * FROM #__messages_cfg WHERE user_id = ? AND cfg_name = ?";
		return $entity->GetFirstResult( $query, array( $user_id, $cfg_name ), __CLASS__ );
	}
}
