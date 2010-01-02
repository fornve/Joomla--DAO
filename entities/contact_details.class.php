<?php defined('_JEXEC') or die('Restricted access');

class Contact_details extends Entity
{
	protected $table_name = '#__contact_details';
	
	static function Retrieve( $id )
	{
		if( !$id )
			return null;
		
		$entity = new Entity();
		$query = "SELECT * FROM #__contact_details WHERE id = ?";
		$object = $entity->GetFirstResult( $query, $id, __CLASS__ );
		
		if( !$object )
			return null;
			
		$object->user = User::Retrieve( $object->user_id );
		
		return $object;
	}
}
