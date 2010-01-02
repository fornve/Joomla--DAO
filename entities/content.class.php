<?php
defined('_JEXEC') or die('Restricted access');

class Content extends Entity
{
	protected $table_name = '#__content';

	static function Retrieve( $id )
	{
		if( !$id )
			return null;
		
		$entity = new Entity();
		$query = "SELECT * FROM #__content WHERE id = ?";
		$object = $entity->GetFirstResult( $query, $id, __CLASS__ );
		
		if( !$object->id )
			return null;
		
		return $object;
	}
	
	static function LatestCollection( $limit = 5 )
	{
		$entity = new Entity();
		$query = "SELECT * FROM #__content WHERE state = 1 ORDER BY id DESC LIMIT ?";
		$objects = $entity->Collection( $query, $limit, __CLASS__ );
		
		if( !$objects[ 0 ]->id )
			return null;
		/*
		foreach( $objects as $object )
		{
			$collection = self::Retrieve( $object->id );
		}*/
		
		return $objects;
	}
}
