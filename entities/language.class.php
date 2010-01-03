<?php defined('_JEXEC') or die('Restricted access');

class Language extends Entity
{
	protected $table_name = '#__languages';
	protected $id_name = 'lang_id';
	
	static function Retrieve( $id )
	{
		return parent::Retrieve( $id, __CLASS__ );
	}
}
