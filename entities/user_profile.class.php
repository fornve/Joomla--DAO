<?php defined('_JEXEC') or die('Restricted access');

class User_profile extends Entity
{
	protected $table_name = '#__user_profile';
	protected $id_name = 'user_id';
	
	static function Retrieve( $user_id, $profile_key )
	{
		// needs custom
	}
}
