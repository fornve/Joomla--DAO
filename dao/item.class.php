<?php
defined('_JEXEC') or die('Restricted access');

class Item extends Entity
{
	protected $schema = array( 'id', 'title', 'alias', 'catid', 'published', 'introtext', 'video', 'gallery', 'extra_fields', 'extra_fields_search', 'created', 'created_by', 'created_by_alias', 'checked_out', 'checked_out_time', 'modified', 'modified_by', 'publish_up', 'publish_down', 'trash', 'access', 'ordering', 'featured', 'featured_ordering', 'image_caption', 'image_credits', 'video_caption', 'video_credits', 'hits', 'params', 'metadesc', 'metadata', 'metakey', 'plugins' );
	protected $table_name = '#__k2_items';

	static function Retrieve( $id )
	{
		if( !$id )
			return null;
		
		$entity = new Entity();
		$query = "SELECT * FROM #__k2_items WHERE id = ?";
		$object = $entity->GetFirstResult( $query, $id, __CLASS__ );
		
		return $object;
	}
	
	static function CategoryCollection( $id )
	{
		if( !$id )
			return null;
		
		$entity = new Entity();
		$query = "SELECT * FROM #__k2_items WHERE catid = ?";
		$object = $entity->Collection( $query, $id, __CLASS__ );
		
		return $object;
	} 
}


