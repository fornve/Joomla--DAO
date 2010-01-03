<?php defined('_JEXEC') or die('Restricted access');

class Banner_track extends Entity
{
	protected $table_name = '#__bannertrack';
	
	static function Retrieve( $id )
	{
		// This is an reference table, this class may need more work
		//return parent::Retrieve( $id, __CLASS__ );
	}
}
