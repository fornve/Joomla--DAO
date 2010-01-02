<?php
defined('_JEXEC') or die('Restricted access');

class Category extends Entity
{
	protected $table_name = '#__categories';

	static function Retrieve( $category_id )
	{
		if( !$category_id )
			return null;
		
		$entity = new Entity();
		$query = "SELECT * FROM #__categories WHERE id = ?";
		$object = $entity->GetFirstResult( $query, $category_id, __CLASS__ );
		
		return $object;
	}

	static function LevelCollection( $category_id )
	{
		if( !isset( $category_id ) || $category_id === null )
			return null;
		
		$entity = new Entity();
		$query = "SELECT id FROM #__categories WHERE parent = ? ORDER BY ordering";
		$objects = $entity->Collection( $query, $category_id, __CLASS__ );
		
		if( $objects ) foreach( $objects as $object )
		{
			$category = self::Retrieve( $object->id );
			
			if( $category )
				$collection[] = $category; 
		}
		
		return $collection;
	} 
	
	function GetKids()
	{
		$entity = new Entity();
		$query = "SELECT * FROM #__categories WHERE parent = ? ORDER BY ordering";
		$objects = $entity->Collection( $query, $this->id, __CLASS__ );
		
		return $objects;
	}
}
